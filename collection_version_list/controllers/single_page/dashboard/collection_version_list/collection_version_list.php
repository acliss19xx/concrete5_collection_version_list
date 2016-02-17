<?php
namespace Concrete\Package\CollectionVersionList\Controller\SinglePage\Dashboard\System\CollectionVersionList;
use \Concrete\Core\Page\Controller\DashboardPageController;
use Page;
use PageList;
use \Concrete\Core\Page\Collection\Version\VersionList;
use Loader;
use Exception;

defined('C5_EXECUTE') or die(_("Access Denied."));

class CollectionVersionList extends DashboardPageController {

	public function on_start() {
		parent::on_start();
	}
	
    public function view() {
        $list = new PageList();
        $list->sortByDisplayOrder();
        $page_result = $list->getResults();
        $cv_list = array();
        foreach($page_result as $res){
            $cv = new VersionList($res);
            if(is_object($cv)){
                $cv_list[$res->getCollectionID()] = $cv->getPage();
                $cv_list[$res->getCollectionID()]['cName'] = $res->getCollectionName();
                $cv_list[$res->getCollectionID()]['cID'] = $res->getCollectionID();
            }
        }
        $this->set('cvlist', $cv_list);
    }
}