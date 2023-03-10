let userBox = document.querySelector('.account-box');
window.addEventListener("scroll",function(){
    userBox.classList.remove('active');
})
document.querySelector('#user-btn').onclick = () =>{
    userBox.classList.toggle('active');
}
document.querySelector('#menu-btn').onclick = () =>{
    userBox.classList.remove('active');
}




