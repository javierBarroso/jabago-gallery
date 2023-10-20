const gallery = document.querySelector('.gallery');
const lightbox = document.querySelector('.lightbox');
const lightboxImg = document.querySelector('.lightbox-img');
const lightboxTitle = document.querySelector('#lightbox-title')
const lightboxDescription = document.querySelector('#lightbox-description')
const closeBtn = document.querySelector('.close-btn');


gallery.querySelectorAll('.image').forEach(img => {img.addEventListener('click', () => {
        
        lightbox.style.display = 'flex';
        
        var title = img.querySelector('.jabago-img-title').innerHTML
        var description = img.querySelector('.jabago-img-description').innerHTML
        
        lightboxImg.src = img.getAttribute('data-img');
        lightboxTitle.innerHTML = title;
        lightboxDescription.innerHTML = description;
    });
});


closeBtn.addEventListener('click', () => {
    
    lightbox.style.display = 'none';
    
    lightboxImg.src = '';
});


lightbox.addEventListener('click', e => {
    if (e.target === lightbox) {
    
        lightbox.style.display = 'none';
        
        lightboxImg.src = '';
    }
});

// var target_object = document.querySelectorAll('.image')
// var i = 0


// target_object.forEach(target => {
//     target.style.transform = 'scale(0)';
//     i ++
// });
// anime({
//     targets:target_object,
//     duration: 1000,
//     easing: 'easeOutElastic(1, 1.1)',
//     scale:1,
//     delay:anime.stagger(60),
// })
