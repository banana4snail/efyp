function Staff(){
    var username = element(by.id('staff-userid')),
        name = element(by.id('staff-name')),
        faculty = element(by.id('staff-faculty_fk')),
        thirdOption = element(by.cssContainingText('option', 'Lee Kong Chian Faculty of Engineering and Science(LKC FES)')),
        department = element(by.id('staff-departments_fk')),
        internetEngineering = element(by.cssContainingText('option','Department of Internet Engineering & Computer Science')),
        email = element(by.id('staff-email')),
        contactNo = element(by.id('staff-contactno')),
        password = element(by.id('staff-password')),
        staff = element(by.css('input[value="1"]')),
        fypCoordinator = element(by.css('input[value="2"]')),
        lecturer = element(by.css('input[value="3"]'));

        this.insertUsername = function(){username.sendKeys('Testing123');};
        this.insertName = function(){name.sendKeys('Jackson');}
        this.insertFaculty = function(){faculty.click(); thirdOption.click();}
        this.insertDepartment = function(){department.click(); internetEngineering.click();}
        this.insertEmail = function(){email.sendKeys('jackson@1utar.my');}
        this.insertContactNo = function(){contactNo.sendKeys('012-3456789');}
        this.insertPassword = function(){password.sendKeys('password');}
        this.insertRole = function(){staff.click(); fypCoordinator.click(); lecturer.click();}
}
module.exports = Staff;