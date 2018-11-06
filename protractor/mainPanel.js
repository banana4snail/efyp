var origFn = browser.driver.controlFlow().execute;

browser.driver.controlFlow().execute = function() {
  var args = arguments;

  // queue 100ms wait
  origFn.call(browser.driver.controlFlow(), function() {
    return protractor.promise.delayed(100);
  });

  return origFn.apply(browser.driver.controlFlow(), args);
};

'use strict';
var Controller = require('./controller.js'),
    AdminPage = require('./adminPage.js'),
    Staff = require('./StaffPanel.js'),
    Student = require('./StudentPanel.js'),
    Faculty = require('./FacultyPanel.js'),
    Department = require('./DepartmentPanel.js'),
    FypType = require('./FypTypePanel.js'),
    Role = require('./RolePanel.js'),
    Title = require('./TitlePanel.js'),
    Calendar = require('./CalendarPanel.js'),
    Announcement = require('./AnnouncementPanel.js'),
    FypDocument = require('./FypDocumentPanel.js'),
    ReportDeadline = require('./ReportDeadlinePanel.js'),
    ReportSubmission = require('./ReportSubmissionPanel.js');

describe('This is my first test', function(){
        var controller = new Controller(),
            adminPage = new AdminPage(),
            staff = new Staff(),
            student = new Student(),
            faculty = new Faculty,
            department = new Department(),
            fypType = new FypType(),
            role = new Role(),
            title = new Title(),
            calendar = new Calendar(),
            announcement = new Announcement(),
            fypDocument = new FypDocument(),
            reportDeadline =  new ReportDeadline(),
            reportSubmission =  new ReportSubmission();

        beforeEach(function () {
          browser.waitForAngularEnabled(false);
         });

         it('Login to admin page', function() {
          adminPage.navigateToLoginPage();
          expect(browser.getTitle()).toEqual('E-fyp Portal');
          adminPage.fillforUsername();
          adminPage.fillforPassword();
          adminPage.goToStaffMainPage();
          expect(browser.getCurrentUrl()).toEqual('http://localhost/efyp/yii2/web/index.php?r=students%2Fadminhome');
        });

        it('Manage Staff',function(){
          controller.navigateToStaffIndex();
          controller.CreateStaff();
          staff.insertUsername();
          staff.insertName();
          staff.insertFaculty();
          staff.insertDepartment();
          staff.insertEmail();
          staff.insertContactNo();
          staff.insertPassword();
          staff.insertRole();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Students',function(){
          controller.navigateToStudentIndex();
          controller.CreateStudents();
          student.insertStudentID();
          student.insertName();
          student.insertRace();
          student.insertGender(); 
          student.insertEmail();
          student.insertPhone();
          student.insertFaculy();
          student.insertCourse();
          student.insertFypType();
          student.insertPassword();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Faculty',function(){
          controller.navigateToFacultyIndex();
          controller.CreateFaculty();
          faculty.insertFaculty();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Departments',function(){
          controller.navigateToDepartmentsIndex();
          controller.CreateDepartments();
          department.insertDepartment();
          department.insertFaculty();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Fyp Type',function(){
          controller.navigateToFypTypeIndex();
          controller.CreateFypType();
          fypType.insertFypType();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Role',function(){
          controller.navigateToRoleIndex();
          controller.CreateRoles();
          role.insertRoles();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Title',function(){
          controller.navigateToTitleIndex();
          controller.CreateTitle();
          title.insertTitle();
          title.insertBatch();
          title.insertFypType();
          title.insertFaculty();
          title.insertDepartment();
          title.insertDescription();
          title.insertEquipmentRequired();
          title.insertSpecialRequirement();
          title.insertIndustrialLinks();
          title.insertCommunityProject();
          title.insertCourse();
          title.insertSupervisor();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Calendar',function(){
          controller.navigateToCalendarIndex();
          controller.SetCalendar();
          calendar.insertActivities();
          calendar.insertDate();
          calendar.insertFypType();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Announcements', function(){
          controller.navigateToAnnouncementsIndex();
          controller.CreateAnnouncements();
          announcement.insertPostTo();
          announcement.insertTitle();
          announcement.insertBody();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Students Download FYP Documents', function(){
          controller.navigateToStudentDownloadFYPDocumentsIndex();
          controller.UploadDocuments();
          fypDocument.insertUploadDocuments();
          fypDocument.insertfypType();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Report Deadlines', function(){
          controller.navigateToReportDeadlinesIndex();
          controller.SetReportDeadlines();
          reportDeadline.insertStartDate();
          reportDeadline.insertDueDate();
          reportDeadline.insertSetToCourse();
          reportDeadline.insertSetToFypType();
          reportDeadline.insertReportTitle();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Manage Report Submission', function(){
          controller.navigateToReportSubmissionIndex();
          controller.CreateReportSubmission();
          reportSubmission.insertStudentID();
          reportSubmission.insertReport();
          reportSubmission.inserFiles();
          controller.confirmationCreate();
          controller.confirmationUpdate();
          controller.confirmationDelete();
          controller.backToHomePage();
        });

        it('Log Out Admin',function(){
          adminPage.LogOut();
        });
});
