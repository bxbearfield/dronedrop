<?php
$showUsersHTML .= '<table class="userScroll"><tr>'
. 	'<td class="">'
. 		($row['picture'] ? 
            '<img src="images/uploads/user_'.$row['user_id'].'/'. $row['picture'].'" class="myPicScroll"/>'
            : 
            '<div class="noData myPicScroll userStockImg"><i class="fas fa-user userStockImg"></i></div>'
        )
.   '</a></td>'			
. 	'<td><div class="demosScroll">'
. 		'<strong>Name:</strong><span id="'.md5($row['email']).'_name"> ' . $row['first_name'] .' '. $row['last_name'] .'</span><br/>'
. 		'<strong>City:</strong> '. $row['city'].'<br/>' 
.		'<strong>State:</strong> '. $row['state'].'</div>'
. 	'</td>'
. 	'<td class="scrollIcons" title="Like"><i class="fas fa-heart"></i></td>'
.	'<td class="userBurgerOpen">'
.			'<div class="userBurgerMenu">'
.			'<span class="scrollIcons" title="Start chat"><i id="'.md5($row['email']).'" class="fas fa-comments startChat"></i></span>'
.			'<span class="scrollIcons" title="Like"><i class="fas fa-heart"></i></span>'
.		'</div>'
.	'</td>'
. 	'<td class="userBurger">'
.		'<i class="fas fa-ellipsis-v burgerDots hide"></i></td>'
. '</tr></table>';
?>