var sideBarIsOpen = true;

toggleBtn.addEventListener('click', (event) => { 
    event.preventDefault()

    if(sideBarIsOpen) {
        dashboard_sidebar.style.width = '10%';
        dashboard_sidebar.style.transition = '0.2s all';
        dashboard_content_container.style.width ='90%';
        dashboard_logo.style.fontSize = '40px';
        userImage.style.width = '60px';
        menuIcons = document.getElementsByClassName('menuText');
        for(var i=0; i < menuIcons.length;i++){
            menuIcons[i].style.display ='none';
        }
        document.getElementsByClassName('dashboard_menu_list')[0].style.textAlign ="center";   
        sideBarIsOpen = false;
    } else {
        dashboard_sidebar.style.width = '20%';
        dashboard_content_container.style.width ='80%';
        dashboard_logo.style.fontSize = '60px';
        userImage.style.width = '95px';
        menuIcons = document.getElementsByClassName('menuText');
        for(var i=0; i < menuIcons.length;i++){
            menuIcons[i].style.display ='inline-block';
        }
        document.getElementsByClassName('dashboard_menu_list')[0].style.textAlign ="normal";
        sideBarIsOpen = true;    


    }
    

});