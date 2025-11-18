  // Article carousel with InteractJS drag
  (function(){
    const carousel = document.getElementById('article-carousel');
    const cards = document.querySelectorAll('.article-card');
    const prevBtn = document.getElementById('prev-article');
    const nextBtn = document.getElementById('next-article');
    const dots = document.querySelectorAll('.indicator-dot');
    
    if(!carousel || !cards.length) return;
    
    let currentIndex = 0;
    const totalCards = cards.length;
    
    function updateCarousel(skipTransition = false){
      cards.forEach((card, i) => {
        const offset = i - currentIndex;
        let x = offset * 420;
        let scale = 1;
        let opacity = 1;
        let zIndex = 10;
        
        if(offset === 0){
          scale = 1.1;
          zIndex = 30;
        } else if(Math.abs(offset) === 1){
          scale = 0.9;
          opacity = 0.7;
          zIndex = 20;
        } else {
          scale = 0.7;
          opacity = 0.3;
          zIndex = 10;
        }
        
        if(skipTransition){
          card.style.transition = 'none';
        } else {
          card.style.transition = 'transform 0.6s cubic-bezier(0.4,0,0.2,1), opacity 0.6s ease';
        }
        
        card.style.transform = `translateX(${x}px) scale(${scale})`;
        card.style.opacity = opacity;
        card.style.zIndex = zIndex;
        
        if(skipTransition){
          setTimeout(() => {
            card.style.transition = 'transform 0.6s cubic-bezier(0.4,0,0.2,1), opacity 0.6s ease';
          }, 10);
        }
      });
      
      dots.forEach((dot, i) => {
        if(i === currentIndex){
          dot.style.backgroundColor = 'rgba(255,255,255,0.9)';
          dot.style.transform = 'scale(1.2)';
        } else {
          dot.style.backgroundColor = 'rgba(255,255,255,0.3)';
          dot.style.transform = 'scale(1)';
        }
      });
    }
    
    function nextSlide(){
      currentIndex = (currentIndex + 1) % totalCards;
      updateCarousel();
    }
    
    function prevSlide(){
      currentIndex = (currentIndex - 1 + totalCards) % totalCards;
      updateCarousel();
    }
    
    if(prevBtn) prevBtn.addEventListener('click', prevSlide);
    if(nextBtn) nextBtn.addEventListener('click', nextSlide);
    
    // InteractJS drag
    if(window.interact){
      cards.forEach((card) => {
        let startX = 0;
        let isDragging = false;
        
        interact(card)
          .draggable({
            inertia: true,
            modifiers: [
              interact.modifiers.restrict({
                restriction: 'parent',
                endOnly: false
              })
            ],
            listeners: {
              start(event){
                isDragging = true;
                startX = event.clientX;
                event.target.style.cursor = 'grabbing';
              },
              move(event){
                const dx = event.clientX - startX;
                if(Math.abs(dx) > 10){
                  event.target.style.transform += ` translateX(${event.dx}px)`;
                }
              },
              end(event){
                const dx = event.clientX - startX;
                event.target.style.cursor = 'grab';
                
                if(Math.abs(dx) > 100){
                  if(dx > 0){
                    prevSlide();
                  } else {
                    nextSlide();
                  }
                } else {
                  updateCarousel();
                }
                
                setTimeout(() => { isDragging = false; }, 100);
              }
            }
          })
          .on('tap', function(event){
            if(!isDragging){
              const url = event.currentTarget.dataset.url;
              if(url){
                window.location.href = url;
              }
            }
          });
      });
    }
    
    updateCarousel(true);
  })();
