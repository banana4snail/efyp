function Faculty(){
    var faculty = element(by.id('faculty-faculty'));
    this.insertFaculty = function(){faculty.sendKeys('New Faculty');}
}
module.exports = Faculty;