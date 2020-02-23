<?php
$showUsersHTML .= '<table class="userScroll"><tr>'
. 	'<td class="">'
.		'<a href="'. (!$row['IG_Private'] ?  $row['first_name'] .'.'. $row['last_name'].'.'.$row['user_id'] : '#').'">'
. 		($row['picture'] ? 
            '<img src="images/uploads/user_'.$row['user_id'].'/'. $row['picture'].'" class="myPicScroll"/>'
            : 
            '<div class="noData myPicScroll userStockImg"><i class="fas fa-user userStockImg"></i></div>'
        )
.   '</a></td>'			
. 	'<td><div class="demosScroll">'
. 		'<strong>Name:</strong><span id="'.md5($row['email']).'_name"> ' . $row['first_name'] .' '. $row['last_name'] .'</span><br/>'
. 		'<strong>Birthdate:</strong> '. $row['month'].'/'.$row['day'].'/'.$row['year'] .'<br/>' 
.		'<strong>Gender:</strong> '. ($row['gender']==1?'M':'F').'</div>'
. 	'</td>'
. 	'<td class="scrollIcons" title="Start chat"><i id="'.md5($row['email']).'" class="fas fa-comments startChat"></i></td>'
. 	'<td class="scrollIcons" title="'.($row['IG_Private'] ? 'View disabled' : 'View').'">'
. 		'<a href="'. ($row['IG_Private'] ? '#' : $row['first_name'] .'.'. $row['last_name'].'.'.$row['user_id']).'">'
.			(!$row['IG_Private'] ? '<i class="far fa-eye">':'<i class="fas fa-eye-slash">').'</i>'
.	'</a></td>'
. 	'<td class="scrollIcons" title="Like"><i class="fas fa-heart"></i></td>'
.	'<td class="userBurgerOpen">'
.			'<div class="userBurgerMenu">'
.			'<span class="scrollIcons" title="Start chat"><i id="'.md5($row['email']).'" class="fas fa-comments startChat"></i></span>'
.			'<a class="scrollIcons" href="'. ($row['IG_Private'] ? '#' : $row['first_name'] .'.'. $row['last_name'].'.'.$row['user_id']).'">'
.				(!$row['IG_Private'] ? '<i title="View" class="far fa-eye">':'<i title="View disabled" class="fas fa-eye-slash">').'</i>'
.			'</a>'
.			'<span class="scrollIcons" title="Like"><i class="fas fa-heart"></i></span>'
.		'</div>'
.	'</td>'
. 	'<td class="userBurger">'
.		'<i class="fas fa-ellipsis-v burgerDots hide"></i></td>'
. '</tr></table>';
?>