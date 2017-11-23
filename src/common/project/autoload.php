<?php
// @codingStandardsIgnoreFile
// @codeCoverageIgnoreStart
// this is an autogenerated file - do not edit
function autoload1fe2f36ac1c7bd2797b0f7e1e3f215f5($class) {
    static $classes = null;
    if ($classes === null) {
        $classes = array(
            'group' => '/Group.class.php',
            'project' => '/Project.class.php',
            'project_accessdeletedexception' => '/AccessDeletedException.class.php',
            'project_accessexception' => '/AccessException.class.php',
            'project_accessprivateexception' => '/AccessPrivateException.class.php',
            'project_accessprojectnotfoundexception' => '/AccessProjectNotFoundException.class.php',
            'project_accessrestrictedexception' => '/AccessRestrictedException.class.php',
            'project_admin_ugroup_paneinfo'                                        => '/Admin/UGroup/PaneInfo.class.php',
            'project_admin_ugroup_panemanagement'             => '/Admin/UGroup/PaneManagement.class.php',
            'project_admin_ugroup_ugroupcontroller'           => '/Admin/UGroup/UGroupController.class.php',
            'project_admin_ugroup_ugroupcontroller_binding'   => '/Admin/UGroup/Controller/Binding.class.php',
            'project_admin_ugroup_ugroupcontroller_members'   => '/Admin/UGroup/Controller/Members.class.php',
            'Tuleap\Project\Admin\ProjectUGroup\UGroupRouter' => '/Admin/UGroup/UGroupRouter.class.php',
            'project_admin_ugroup_view'                       => '/Admin/UGroup/View.class.php',
            'project_admin_ugroup_view_binding'               => '/Admin/UGroup/View/Binding.class.php',
            'project_admin_ugroup_view_editbinding'           => '/Admin/UGroup/View/EditBinding.class.php',
            'project_admin_ugroup_view_editdirectorygroup'    => '/Admin/UGroup/View/EditDirectoryGroup.class.php',
            'project_admin_ugroup_view_members'                                    => '/Admin/UGroup/View/Members.class.php',
            'project_admin_ugroup_view_permissions' => '/Admin/UGroup/View/Permissions.class.php',
            'project_admin_ugroup_view_settings' => '/Admin/UGroup/View/Settings.class.php',
            'project_admin_ugroup_view_showbinding' => '/Admin/UGroup/View/ShowBinding.class.php',
            'project_admin_ugroup_view_ugroupaction' => '/Admin/UGroup/View/UGroupAction.class.php',
            'project_creation_exception' => '/Project_Creation_Exception.class.php',
            'project_customdescription_customdescription' => '/CustomDescription/CustomDescription.class.php',
            'project_customdescription_customdescriptiondao' => '/CustomDescription/CustomDescriptionDao.class.php',
            'project_customdescription_customdescriptionfactory' => '/CustomDescription/CustomDescriptionFactory.class.php',
            'project_customdescription_customdescriptionpresenter' => '/CustomDescription/CustomDescriptionPresenter.class.php',
            'project_customdescription_customdescriptionvaluedao' => '/CustomDescription/CustomDescriptionValueDao.class.php',
            'project_customdescription_customdescriptionvaluefactory' => '/CustomDescription/CustomDescriptionValueFactory.class.php',
            'project_customdescription_customdescriptionvaluemanager' => '/CustomDescription/CustomDescriptionValueManager.class.php',
            'project_hierarchymanager' => '/Hierarchy/HierarchyManager.class.php',
            'project_hierarchymanageralreadyancestorexception' => '/Hierarchy/HierarchyManagerAlreadyAncestorException.class.php',
            'project_hierarchymanagerancestorisselfexception' => '/Hierarchy/HierarchyManagerAncestorIsSelfException.class.php',
            'project_hierarchymanagernochangeexception' => '/Hierarchy/HierarchyManagerNoChangeException.class.php',
            'project_invalidfullname_exception' => '/Project_InvalidFullName_Exception.class.php',
            'project_invalidshortname_exception' => '/Project_InvalidShortName_Exception.class.php',
            'project_onestepcreation_onestepcreationcontroller' => '/OneStepCreation/OneStepCreationController.class.php',
            'project_onestepcreation_onestepcreationpresenter' => '/OneStepCreation/OneStepCreationPresenter.class.php',
            'project_onestepcreation_onestepcreationrequest' => '/OneStepCreation/OneStepCreationRequest.class.php',
            'project_onestepcreation_onestepcreationrouter' => '/OneStepCreation/OneStepCreationRouter.class.php',
            'project_onestepcreation_onestepcreationvalidator' => '/OneStepCreation/OneStepCreationValidator.class.php',
            'project_service_serviceusage' => '/Service/ServiceUsage.class.php',
            'project_service_serviceusagedao' => '/Service/ServiceUsageDao.class.php',
            'project_service_serviceusagefactory' => '/Service/ServiceUsageFactory.class.php',
            'project_service_serviceusagemanager' => '/Service/ServiceUsageManager.class.php',
            'project_soapserver' => '/Project_SOAPServer.class.php',
            'projectcreationtemplatepresenter' => '/ProjectCreationTemplatePresenter.class.php',
            'projectcreator' => '/ProjectCreator.class.php',
            'projectmanager' => '/ProjectManager.class.php',
            'projectxmlexporter' => '/ProjectXMLExporter.class.php',
            'projectxmlimporter' => '/ProjectXMLImporter.class.php',
            'registerprojectstep' => '/RegisterProjectStep.class.php',
            'registerprojectstep_basicinfo' => '/RegisterProjectStep_BasicInfo.class.php',
            'registerprojectstep_category' => '/RegisterProjectStep_Category.class.php',
            'registerprojectstep_confirmation' => '/RegisterProjectStep_Confirmation.class.php',
            'registerprojectstep_intro' => '/RegisterProjectStep_Intro.class.php',
            'registerprojectstep_license' => '/RegisterProjectStep_License.class.php',
            'registerprojectstep_name' => '/RegisterProjectStep_Name.class.php',
            'registerprojectstep_services' => '/RegisterProjectStep_Services.class.php',
            'registerprojectstep_settings' => '/RegisterProjectStep_Settings.class.php',
            'registerprojectstep_template' => '/RegisterProjectStep_Template.class.php',
            'service' => '/Service.class.php',
            'servicenotallowedforprojectexception' => '/ServiceNotAllowedForProjectException.class.php',
            'tuleap\\project\\rest\\projectinforepresentation' => '/REST/ProjectInfoRepresentation.class.php',
            'tuleap\\project\\rest\\v1\\projectresource' => '/REST/v1/ProjectResource.class.php',
            'ugroup' => '/UGroup.class.php',
            'ugroup_invalid_exception' => '/UGroup_Invalid_Exception.class.php',
            'ugroupbinding' => '/UGroupBinding.class.php',
            'ugroupliteralizer' => '/UGroupLiteralizer.class.php',
            'ugroupmanager' => '/UGroupManager.class.php'
        );
    }
    $cn = strtolower($class);
    if (isset($classes[$cn])) {
        require dirname(__FILE__) . $classes[$cn];
    }
}
spl_autoload_register('autoload1fe2f36ac1c7bd2797b0f7e1e3f215f5');
// @codeCoverageIgnoreEnd
