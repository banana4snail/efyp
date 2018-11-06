'use strict';
function Controller(){
        /**index element*/
    var manageStaff = element(by.partialLinkText('Manage Staff')),
        manageStudents = element(by.partialLinkText('Manage Students')),
        manageFaculty = element(by.partialLinkText('Manage Faculty')),
        manageDepartments = element(by.partialLinkText('Manage Departments')),
        manageFypType = element(by.partialLinkText('Manage Fyp Type')),
        manageRole = element(by.partialLinkText('Manage Role')),
        manageTitle = element(by.partialLinkText('Manage Title')),
        manageCalendar = element(by.partialLinkText('Manage Calendar')),
        manageAnnouncements = element(by.partialLinkText('Manage Announcements')),
        manageDownload = element(by.partialLinkText('Manage Students Download FYP Documents')),
        manageReportDeadlines = element(by.partialLinkText('Manage Report Deadlines')),
        manageReportSubmission = element(by.partialLinkText('Manage Report Submission')),

        /**create element */
        createStaff = element(by.partialLinkText('Create Staff')),
        createStudents = element(by.partialLinkText('Create Students')),
        createFaculty = element(by.partialLinkText('Create Faculty')),
        createDepartments = element(by.partialLinkText('Create Departments')),
        createFypType = element(by.partialLinkText('Create Fyptype')),
        createRoles = element(by.partialLinkText('Create Roles')),
        createTitle = element(by.partialLinkText('Create Title')),
        setCalendar = element(by.partialLinkText('Set Calendar')),
        createAnnouncements = element(by.partialLinkText('Create Announcement')),
        uploadDocuments = element(by.partialLinkText('Upload Documents')),
        setReportDeadlines = element(by.linkText('Set Report Deadlines')),
        createReportSubmission = element(by.partialLinkText('Create Reportsubmission')),

        /**main element*/
        homeBtn = element(by.partialLinkText('Home')),
        createBtn = element(by.buttonText('Create')),
        update = element(by.partialLinkText('Update')),
        updateBtn = element(by.buttonText('Update')),
        deleteBtn = element(by.partialLinkText('Delete'));

    /**Navigate to Index Screen */
    this.navigateToStaffIndex = function(){ manageStaff.click();}  
    this.navigateToStudentIndex = function(){manageStudents.click();}
    this.navigateToFacultyIndex = function(){manageFaculty.click();}
    this.navigateToDepartmentsIndex = function(){manageDepartments.click();}
    this.navigateToFypTypeIndex = function(){manageFypType.click();}
    this.navigateToRoleIndex = function(){manageRole.click();}
    this.navigateToTitleIndex = function(){manageTitle.click();}
    this.navigateToCalendarIndex = function(){manageCalendar.click();}
    this.navigateToAnnouncementsIndex = function(){manageAnnouncements.click();}
    this.navigateToStudentDownloadFYPDocumentsIndex = function(){manageDownload.click();}
    this.navigateToReportDeadlinesIndex = function(){manageReportDeadlines.click();}
    this.navigateToReportSubmissionIndex = function(){manageReportSubmission.click();}

    /**Create Screen */
    this.CreateStaff = function(){createStaff.click();}
    this.CreateStudents = function(){createStudents.click();}
    this.CreateFaculty = function(){createFaculty.click();}
    this.CreateDepartments = function(){createDepartments.click();}
    this.CreateFypType = function(){createFypType.click();}
    this.CreateRoles = function(){createRoles.click();}
    this.CreateTitle = function(){createTitle.click();}
    this.SetCalendar = function(){setCalendar.click();}
    this.CreateAnnouncements = function(){createAnnouncements.click();}
    this.UploadDocuments = function(){uploadDocuments.click();}
    this.SetReportDeadlines = function(){setReportDeadlines.click();}
    this.CreateReportSubmission = function(){createReportSubmission.click();}

    /**Main button */
    this.backToHomePage = function(){homeBtn.click();}
    this.confirmationCreate = function(){createBtn.click();}
    this.confirmationUpdate = function(){update.click(); updateBtn.click();}
    this.confirmationDelete = function(){deleteBtn.click(); browser.switchTo().alert().accept();}
}
module.exports = Controller;