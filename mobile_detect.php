jQuery(function() {      
    let isMobile = window.matchMedia("only screen and (max-width: 760px)").matches;

    if (isMobile) {
		setTimeout(function(){
			jQuery('body.page').trigger('click');
			const element = document.querySelector('body');
			element.click();
			
			// jQuery('body.page').click(function(){
				  // alert("Suppppppp!"); 
				// });
			
		}, 2000);//wait 2 seconds
        
    }
 });
