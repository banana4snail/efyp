function Student(){
    var studentID = element(by.id('students-studentid')),
        name = element(by.id('students-name')),
        race = element(by.id('students-race')),
        chinese = element(by.cssContainingText('option', 'Chinese')),
        gender = element(by.id('students-gender')),
        male = element(by.cssContainingText('option','Male')),
        email = element(by.id('students-email')),
        phone = element(by.id('students-phone')),
        faculty = element(by.id('students-faculty')),
        thirdOption = element(by.cssContainingText('option', 'Lee Kong Chian Faculty of Engineering and Science(LKC FES)')),
        course = element(by.id('students-course')),
        softwareEngineering = element(by.cssContainingText('option', 'Bachelor of Science (Hons) Software Engineering')),
        fypType = element(by.id('students-fyptype')),
        part1Students = element(by.cssContainingText('option', 'Part 1 Students')),
        password = element(by.id('students-password'));

        this.insertStudentID = function(){studentID.sendKeys('1700123');}
        this.insertName = function(){name.sendKeys('Jackson');}
        this.insertRace = function(){race.click(); chinese.click();}
        this.insertGender = function(){gender.click(); male.click();}
        this.insertEmail = function(){email.sendKeys('jackson@1utar.my');}
        this.insertPhone = function(){phone.sendKeys('012-3456789');}
        this.insertFaculy = function(){faculty.click(); thirdOption.click();}
        this.insertCourse = function(){course.click(); softwareEngineering.click();}
        this.insertFypType = function(){fypType.click(); part1Students.click();}
        this.insertPassword = function(){password.sendKeys('password');}
}
module.exports = Student;