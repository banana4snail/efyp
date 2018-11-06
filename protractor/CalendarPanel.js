function Calendar(){
    var activites = element(by.id('calendar-activities')),
        date = element(by.id('calendar-date')),
        fypType = element(by.id('calendar-fyptypeid')),
        part1Students = element(by.cssContainingText('option', 'Part 1 Students'));

        this.insertActivities = function(){activites.sendKeys('New Activities');}
        this.insertDate = function(){date.sendKeys('2019-01-16');}
        this.insertFypType = function(){fypType.click(); part1Students.click();}
}
module.exports = Calendar;