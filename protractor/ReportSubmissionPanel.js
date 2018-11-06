function ReportSubmission(){
    var studentID = element(by.id('reportsubmission-student_id')),
        report = element(by.id('reportsubmission-report')),
        uploadDocuments = element(by.id('reportsubmission-files'));

    this.insertStudentID = function(){studentID.sendKeys('150123');}
    this.insertReport = function(){report.sendKeys('Testing');}
    this.inserFiles = function(){
        var path = require('path');
        var fileToUpload = 'sample.pdf',
        absolutePath = path.resolve(__dirname, fileToUpload);
        uploadDocuments.sendKeys(absolutePath);
    }
}
module.exports = ReportSubmission;