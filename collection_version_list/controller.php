<?php 
namespace Concrete\Package\CollectionVersionList;
 
use Concrete\Core\Package\Package;
use \Concrete\Core\Page\Single as SinglePage;

defined('C5_EXECUTE') or die(_("Access Denied."));
 
class Controller extends Package
{
    protected $pkgHandle = 'collection_version_list';
    protected $appVersionRequired = '5.7.1';
    protected $pkgVersion = '0.9.0';
    
    public function getPackageDescription()
    {
        return t("To display the page version list of each page .");
    }
     
    public function getPackageName()
    {
        return t("collection version list");
    }
    public function install()
    {
        $pkg = parent::install();
        SinglePage::add('/dashboard/collection_version_list', $pkg);
        SinglePage::add('/dashboard/collection_version_list/search', $pkg);
    }
}