/*
* accordion
* */
const $accordionItems = document.querySelectorAll('.js_accordion_item');

$accordionItems.forEach(item => {
    const itemHeader = item.querySelector('.js_accordion_header');
    const itemText = item.querySelector('.js_accordion_text');

    itemHeader.addEventListener('click', () => {

        if (itemText.style.maxHeight) {
            //this is if the accordion is open

            itemHeader.parentElement.classList.remove('active')
            itemHeader.style.marginBottom = null;
            itemText.style.maxHeight = null;

        } else {
            //if the accordion is currently closed

            itemHeader.parentElement.classList.add('active')
            itemHeader.style.marginBottom = "16px";
            itemText.style.maxHeight = itemText.scrollHeight + "px";
        }
    })
})


/*
* review-slider
* */
const swiper = new Swiper('.swiper-container', {
    slidesPerView: 3,
    spaceBetween: 30,

    pagination: {
        el: '.swiper-pagination',
    },

    navigation: {
        nextEl: '.swiper-my-button-prev',
        prevEl: '.swiper-my-button-next',
    }
});


/*
* anchor-scroll
* */
const anchors = document.querySelectorAll('a[href*="#"]');
const scrollToPos = (num) => {
    window.scrollTo({
        top: num - 72,
        behavior: 'smooth'
    });
}

for (let anchor of anchors) {
    anchor.addEventListener('click', function (e) {
        e.preventDefault();

        const blockID = anchor.getAttribute('href').substr(1);
        const element = document.getElementById(blockID);
        const y = element.getBoundingClientRect().top + window.pageYOffset;

        scrollToPos(y)
    })
}


/*
* header-links activating
* */
const sections = document.querySelectorAll('section[id]');
const links = document.querySelectorAll('.js_menu_link');
let sectionsParams = [];

const getSectionParams = () => {
    sectionsParams = []
    sections.forEach((item) => {
        sectionsParams.push({
            id: item.id,
            offsetTop: item.offsetTop,
            height: item.clientHeight,
        });
    });
}

getSectionParams();

window.onresize = getSectionParams;

const getCurrentId = (pageYOffset) => {
    for (let section of sectionsParams) {

        if (pageYOffset >= section.offsetTop && pageYOffset < (section.offsetTop + section.height)) {
            return section.id
        }
    }
}

const scroll = () => {
    let pageYOffset = window.pageYOffset,
        currentSection = getCurrentId(pageYOffset + 72);

    if (currentSection) {
        for (let link of links) {
            let linkId = link.getAttribute('href').replace('#', '');
            if (linkId === currentSection) {
                if (!link.classList.contains('active')) {
                    for (let el of links) {
                        if (el.classList.contains('active')) el.classList.remove('active')
                    }
                    link.classList.add('active')
                }
            }
        }
    } else {
        for (let el of links) {
            if (el.classList.contains('active')) el.classList.remove('active')
        }
    }
}

window.addEventListener('scroll', scroll);