function FypDocument(){
    var uploadDocuments = element(by.id('downloads-documents')),
        fypType = element(by.id('downloads-fyptype_id')),
        part1Students = element(by.cssContainingText('option', 'Part 1 Students'));
    this.insertUploadDocuments = function(){
        var path = require('path');
        var fileToUpload = 'sample.pdf',
        absolutePath = path.resolve(__dirname, fileToUpload);
        uploadDocuments.sendKeys(absolutePath);
    }
    this.insertfypType = function(){fypType.click(); part1Students.click();}
}
module.exports = FypDocument;