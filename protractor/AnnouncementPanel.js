function Announcement(){
    var postTo = element(by.id('announcement-fyptypeid')),
        part1Students = element(by.cssContainingText('option', 'Part 1 Students')),
        title = element(by.id('announcement-title')),
        body = element(by.id('announcement-body'));
    this.insertPostTo = function(){postTo.click(); part1Students.click();}
    this.insertTitle = function(){title.sendKeys('Important announcement');}
    this.insertBody = function(){body.sendKeys('Please upload your fyp project by tomorrow');}
}
module.exports = Announcement;