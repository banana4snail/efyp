function Department(){
    var department = element(by.id('departments-department')),
        faculty = element(by.id('departments-faculty_fk')),
        thirdOption = element(by.cssContainingText('option', 'Lee Kong Chian Faculty of Engineering and Science(LKC FES)'));
        
    this.insertDepartment = function(){department.sendKeys('New Department');}
    this.insertFaculty = function(){faculty.click(); thirdOption.click();}
}
module.exports = Department;