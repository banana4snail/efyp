function Role(){
    var roles = element(by.id('roles-roles'));
    this.insertRoles = function(){roles.sendKeys('New Roles');}
}
module.exports = Role;