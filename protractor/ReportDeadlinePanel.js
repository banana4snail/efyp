function ReportDeadline(){
    var setToCourse = element(by.id('report-course')),
        softwareEngineering = element(by.cssContainingText('option', 'Bachelor of Science (Hons) Software Engineering')),
        setToFypType = element(by.id('report-fyptype')),
        part1Students = element(by.cssContainingText('option', 'Part 1 Students')),
        reportTitle = element(by.id('report-name')),
        startDate = element(by.id('report-start')),
        dueDate = element(by.id('report-due'));

        this.insertSetToCourse = function(){setToCourse.click(); softwareEngineering.click();}
        this.insertSetToFypType = function(){setToFypType.click(); part1Students.click();}
        this.insertReportTitle = function(){reportTitle.sendKeys('Important report');}
        this.insertStartDate = function(){startDate.sendKeys('2018-11-01 00:30');}
        this.insertDueDate = function(){dueDate.sendKeys('2018-11-30 23:55');}
}
module.exports = ReportDeadline;