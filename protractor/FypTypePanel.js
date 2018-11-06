function FypType(){
    var fypType = element(by.id('fyptype-fyptype'));
    this.insertFypType = function(){fypType.sendKeys('New FypType');}
}
module.exports = FypType;