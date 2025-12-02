<?php

require_once 'assests/php/functions.php';
if(isset($_SESSION['Auth'])){
    $user = getUser($_SESSION['userdata']['id']);
    $posts=filterPosts();
    $follow_suggestions=filterFollowSuggestion();
}
 
$pagecount = count($_GET);

if(isset($_SESSION['Auth']) && $user['ac_status']==1 &&  !$pagecount){
    showPage('header',['page_title'=>'OSN-Home']);
    showPage('navbar');
    showPage('wall');
}
else if(isset($_SESSION['Auth']) && $user['ac_status']==0 && !$pagecount){
    showPage('header',['page_title'=>'Verify Email']);
    showPage('verify_email');
}
else if(isset($_SESSION['Auth']) && $user['ac_status']==2 && !$pagecount){
    showPage('header',['page_title'=>'Blocked']);
    showPage('blocked');
}
elseif(isset($_SESSION['Auth']) && isset($_GET['editprofile']) && $user['ac_status']==1){
    showPage('header',['page_title'=>'Edit Profile']);
    showPage('navbar');
    showPage('edit_profile');
}
elseif(isset($_SESSION['Auth']) && isset($_GET['u']) && $user['ac_status']==1){
    $profile = getUserByUsername($_GET['u']);
    if(!$profile){
        showPage('header',['page_title'=>'User Not Found']);
        showPage('navbar');
        showPage('user_not_found');

    }else{
     $profile_post = getPostById($profile['id']);  
     $profile['followers']=getFollowers($profile['id']);
     $profile['following']=getFollowing($profile['id']);
        showPage('header',['page_title'=>$profile['first_name'].' '.$profile['last_name']]);
        showPage('navbar');
        showPage('profile');
    }
 
}
else if(isset($_GET['signup'])){

    showPage('header',['page_title'=>'OSN-Signup']);
    showPage('signup');
}else if(isset($_GET['login'])){
    showPage('header',['page_title'=>'OSN-Login']);
    showPage('login');}
else if(isset($_GET['forgotpassword'])){
     showPage('header',['page_title'=>'OSN-Login']);
    showPage('forgot_password');
}else{
    if(isset($_SESSION['Auth']) && $user['ac_status']==1){
        showPage('header',['page_title'=>'Home']);
        showPage('navbar');
        showPage('wall');
    }elseif(isset($_SESSION['Auth']) && $user['ac_status']==0){

        showPage('header',['page_title'=>'Verify Your Email']);
        showPage('verify_email');
    }elseif(isset($_SESSION['Auth']) && $user['ac_status']==2){
        showPage('header',['page_title'=>'Blocked']);
        showPage('blocked');
    }else{
        showPage('header',['page_title'=>'Pictogram - Login']);
        showPage('login');
    }
}

showPage('footer');
unset($_SESSION['error']);
unset($_SESSION['formdata']);

?>