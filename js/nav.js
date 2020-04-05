(function() {	
    var userMenus = document.querySelectorAll(".userBurger");
    var hambugerNav = getNode('div.hamburger');
    var showHamburger = getNode('div#showHamburger');
    var media = [
        '(max-width: 1060px)',
        '(max-width: 963px)',
        '(max-width: 814px)',
        '(max-width: 596px)'
    ]
    var s;
    var q = '';
    
    //Display different elements at alternating media queries
    for (var i=0; i<media.length; i++) {
        q = window.matchMedia("only screen and " + media[i]);
        if (media[i] == '(max-width: 814px)') {
            s = ['div.hamburger'];
        } else {s = ['i.burgerDots', 'td.scrollIcons']; }
        for (var j=0; j<s.length; j++){mediaHandler(q, s[j]);}
    } 
    
    //Add handler for user burger menus
	for (var j=0; j<userMenus.length; j++) {
        var menu = userMenus[j];
        addShowUserMenu_Handler(menu,j);
    }

    //Click nav burger to display menu
    addEventHandler(hambugerNav, 'click', function(){
        showHamburger.classList.toggle('openHamburger');
    });

    //Close menu on mouse leave
    // addEventHandler(showHamburger, 'mouseleave', function(){
    //     showHamburger.removeClass('openHamburger');
    // });
    	
})();

function mediaQuery(q, selector){
    var s = document.querySelectorAll(selector);
    if (q.matches) {
        for (var i=0; i<s.length; i++) {
            s[i].classList.toggle('hide');
        }
    }
}

function mediaHandler(q, selector){
    mediaQuery(q,selector);
    addEventHandler(q, 'change', function() {
        var s = document.querySelectorAll(selector);
        for (var i=0; i<s.length; i++) {
                s[i].classList.toggle('hide');
            }
        }
    )
}

function addShowUserMenu_Handler(menu,i) {
    //Handler for user responsive menu burgerDots
    addEventHandler(menu, 'click', function(){showMenuDisplay(i)});
}

function showMenuDisplay(myIndex){
    //Handler for user responsive menu burgerDots
    var menus = document.getElementsByClassName("userBurgerOpen");
    //Close other menu if open
    for (var i=0; i<menus.length; i++) {
        var menu = menus[i];
		if (menu.classList.contains('open') && i !== myIndex) {
			menu.removeClass('open');
		}
    }
    //Toggle userBurger menus open and closed
    menus[myIndex].classList.toggle('open');
    
    addEventHandler(menus[myIndex].childNodes[0], 'mouseleave', function(e) {
        var me = getActivatedObject(e);
        me.parentNode.removeClass('open');
    });
}

function logout() {
	var logoutConfirm = confirm('Are you sure you want to log out?');
	return logoutConfirm ? true:false;
}