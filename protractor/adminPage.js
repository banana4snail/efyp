function adminPage(){
    var inputUsername = element(by.id('loginform-username')),
        inputPassword = element(by.id('loginform-password')),
        loginButton = element(by.id('login-button')),
        logoutButton = element(by.buttonText('Logout (admin)'));
       

    this.navigateToLoginPage = function(){
        browser.waitForAngularEnabled(false);
        browser.get('http://localhost/efyp/yii2/web/index.php');
    }

    this.goToStaffMainPage = function(){
        loginButton.click();
    }

    this.fillforUsername = function(){
        inputUsername.sendKeys('admin');
    }

    this.fillforPassword = function(){
        inputPassword.sendKeys('admin');
    }

    this.LogOut = function(){
        logoutButton.click();
    }
}

module.exports = adminPage;