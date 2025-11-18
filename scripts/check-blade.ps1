$pairs = @(
  @{o='@if'; c='@endif'},
  @{o='@foreach'; c='@endforeach'},
  @{o='@forelse'; c='@endforelse'},
  @{o='@isset'; c='@endisset'},
  @{o='@section'; c='@endsection'},
  @{o='@auth'; c='@endauth'},
  @{o='@guest'; c='@endguest'},
  @{o='@for'; c='@endfor'},
  @{o='@while'; c='@endwhile'},
  @{o='@switch'; c='@endswitch'},
  @{o='@php'; c='@endphp'}
)

Get-ChildItem -Path .\resources\views -Recurse -Filter *.blade.php | ForEach-Object {
  $path = $_.FullName
  try {
    $text = Get-Content $path -Raw -ErrorAction Stop
  } catch {
    Write-Output ("Could not read {0}: {1}" -f $path, $_.Exception.Message)
    continue
  }

  foreach ($p in $pairs) {
    $open = ([regex]::Matches($text, [regex]::Escape($p.o))).Count
    $close = ([regex]::Matches($text, [regex]::Escape($p.c))).Count
    if ($open -ne $close) {
      Write-Output "$path -- $($p.o):$open $($p.c):$close"
    }
  }
}

Write-Output "Check complete."
