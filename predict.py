# predict.py
import sys
import os
import json
import cv2
from ultralytics import YOLO

# Helper untuk menutup sementara stdout/stderr (supress YOLO prints)
class _DevNull:
    def write(self, *args, **kwargs):
        pass
    def flush(self): pass

def run():
    if len(sys.argv) != 4:
        print(json.dumps({"error": "bad_args", "usage": "predict.py <input> <output> <model>"}))
        sys.exit(1)

    inp = sys.argv[1]
    outp = sys.argv[2]
    model_path = sys.argv[3]

    if not os.path.exists(model_path):
        print(json.dumps({"error": "model_not_found", "model_path": model_path}))
        sys.exit(3)

    if not os.path.exists(inp):
        print(json.dumps({"error": "input_not_found", "input_path": inp}))
        sys.exit(4)

    # load model
    try:
        model = YOLO(model_path)
    except Exception as e:
        print(json.dumps({"error": "model_load_failed", "message": str(e)}))
        sys.exit(5)

    # run inference while suppressing prints to stdout/stderr
    real_stdout = sys.stdout
    real_stderr = sys.stderr
    devnull = _DevNull()
    try:
        sys.stdout = devnull
        sys.stderr = devnull
        results = model(inp, save=False)  # call model; prints are suppressed
    finally:
        sys.stdout = real_stdout
        sys.stderr = real_stderr

    if not results or len(results) == 0:
        print(json.dumps({"error": "no_results"}))
        sys.exit(6)

    res = results[0]

    # create annotated image using plot() / .plot() result
    try:
        # res.plot() returns numpy image in many ultralytics versions
        annotated_img = res.plot()  # may return ndarray
        # write to outp
        cv2.imwrite(outp, annotated_img)
        annotated_abs = os.path.abspath(outp)
    except Exception as e:
        # fall back: try save to default saved location
        annotated_abs = None

    preds = []
    try:
        # boxes handling for different ultralytics versions
        boxes = getattr(res, "boxes", None)
        if boxes is None:
            # some versions return .boxes.data
            boxes = getattr(res, "pred", getattr(res, "boxes", None))

        # boxes might be a list-like of Box objects
        if boxes is not None:
            # iterate boxes; support b.xyxy / b.conf / b.cls OR boxes.xyxy etc
            for b in boxes:
                try:
                    # box object
                    xyxy = None
                    conf = None
                    cls_id = None

                    if hasattr(b, "xyxy"):
                        xy = b.xyxy
                        # b.xyxy might be tensor-like
                        if hasattr(xy, "tolist"):
                            xyxy = xy.tolist()[0] if isinstance(xy.tolist(), list) and len(xy.tolist())>0 and isinstance(xy.tolist()[0], list) else xy.tolist()
                    elif hasattr(b, "xyxyn"):
                        xy = b.xyxyn
                        xyxy = xy.tolist()
                    elif hasattr(b, "data"):
                        # sometimes boxes.data is tensor
                        arr = b.data
                        if hasattr(arr, "tolist"):
                            xyxy = arr.tolist()

                    if hasattr(b, "conf"):
                        conf = float(b.conf.tolist()[0]) if hasattr(b.conf, "tolist") else float(b.conf)
                    elif hasattr(b, "confidence"):
                        conf = float(b.confidence)
                    if hasattr(b, "cls"):
                        cls_id = int(b.cls.tolist()[0]) if hasattr(b.cls, "tolist") else int(b.cls)
                    elif hasattr(b, "label"):
                        # fallback - label string
                        cls_id = b.label

                    # if xyxy is still not correct, attempt boxes.xyxy on res
                    if xyxy is None and hasattr(res, "boxes") and hasattr(res.boxes, "xyxy"):
                        try:
                            all_xyxy = res.boxes.xyxy.tolist()
                            # this loop assumes same index ordering - but if only one box, pick first
                            if len(all_xyxy) > 0:
                                xyxy = all_xyxy[0]
                        except Exception:
                            xyxy = None

                    if xyxy is None:
                        continue

                    # obtain label text
                    label_text = None
                    try:
                        names = getattr(model, "names", None)
                        if isinstance(cls_id, int) and names and cls_id in names:
                            label_text = names[cls_id]
                        elif isinstance(cls_id, str):
                            label_text = cls_id
                        else:
                            label_text = str(cls_id)
                    except Exception:
                        label_text = str(cls_id)

                    preds.append({
                        "label": label_text,
                        "confidence": float(conf) if conf is not None else None,
                        "bbox": [int(xyxy[0]), int(xyxy[1]), int(xyxy[2]), int(xyxy[3])]
                    })
                except Exception:
                    # skip malformed box
                    continue
    except Exception:
        preds = []

    infected = 1 if len(preds) > 0 else 0

    out = {
        "ok": True,
        "predictions": preds,
        "infected": infected,
        "annotated_path": os.path.abspath(outp) if annotated_abs is None else annotated_abs
    }

    print(json.dumps(out))

if __name__ == "__main__":
    run()
