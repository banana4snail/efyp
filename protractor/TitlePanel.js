function Title(){
    var title = element(by.id('title-title')),
        batch = element(by.id('title-batch')),
        fypType = element(by.id('title-category')),
        part1Students = element(by.cssContainingText('option', 'Part 1')),
        faculty = element(by.id('title-faculty')),
        thirdOption = element(by.cssContainingText('option', 'Lee Kong Chian Faculty of Engineering and Science(LKC FES)')),
        department = element(by.id('title-departments')),
        internetEngineering = element(by.cssContainingText('option','Department of Internet Engineering & Computer Science')),
        description = element(by.id('title-descriptions')),
        equipmentRequired = element(by.id('title-equipment')),
        specialRequirement = element(by.id('title-requirements')),
        industrialLinks = element(by.id('title-industriallinks')),
        communityProject = element(by.id('title-commprojects')),
        course = element(by.id('title-coursearray')),
        softwareEngineering = element(by.cssContainingText('option', 'Bachelor of Science (Hons) Software Engineering')),
        supervisor = element(by.id('title-supervisor')),
        selectedSupervisor = element(by.cssContainingText('option', 'Hoo Mei Hao'));

        this.insertTitle = function(){title.sendKeys('E-fyp portal');}
        this.insertBatch = function(){batch.sendKeys('January 2018');}
        this.insertFypType = function(){fypType.click(); part1Students.click();}
        this.insertFaculty = function(){faculty.click(); thirdOption.click();}
        this.insertDepartment = function(){department.click(); internetEngineering.click();}
        this.insertDescription = function(){description.sendKeys('this is a final year project portal');}
        this.insertEquipmentRequired = function(){equipmentRequired.sendKeys('required good spec of computer');}
        this.insertSpecialRequirement = function(){specialRequirement.sendKeys('-');}
        this.insertIndustrialLinks = function(){industrialLinks.sendKeys('-');}
        this.insertCommunityProject = function(){communityProject.sendKeys('-');}
        this.insertCourse = function(){course.click(); softwareEngineering.click();}
        this.insertSupervisor = function(){supervisor.click(); selectedSupervisor.click();}
}
module.exports = Title;