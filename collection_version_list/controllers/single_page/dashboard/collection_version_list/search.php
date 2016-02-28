<?php
namespace Concrete\Package\CollectionVersionList\Controller\SinglePage\Dashboard\CollectionVersionList;
use \Concrete\Core\Page\Controller\DashboardPageController;
use Page;
use Concrete\Core\Page\Type;
use PageList;
use \Concrete\Core\Page\Collection\Version\VersionList;
use \Concrete\Core\Legacy\ItemList;
use \Concrete\Core\Http\ResponseAssetGroup;
use Loader;
use Exception;

defined('C5_EXECUTE') or die(_("Access Denied."));

class Search extends DashboardPageController {

	public function on_start() {
		parent::on_start();
	}
	
    public function view() {
        $this->ptID = intval($this->request->query->get('ptID'));
        $this->cParentID = intval($this->request->query->get('cParentID'));
        $this->lastestversion = isset($_GET['lastestversion']) ? true:false; 
        $list = new PageList();
        $list->sortByDisplayOrder();
        if($this->ptID > 0){
            $list->filterByPageTypeID(intval($this->ptID));
        }
        if($this->cParentID != 0){
            $list->filterByPath(Page::getByID($this->cParentID)->getCollectionPath());
        }
        $page_result = $list->getResults();

        $cv_list = array();
        foreach($page_result as $res){
            $cv = new VersionList($res);
            if(is_object($cv)){
                if($this->lastestversion == true){
                    $cvcheck = $cv->getPage(-1);
                    if($cvcheck[0]->cvIsApproved != 1){
                        $cv_list[$res->getCollectionID()]['vObj'] = $cv->getPage(-1);
                        $cv_list[$res->getCollectionID()]['cName'] = $res->getCollectionName();
                        $cv_list[$res->getCollectionID()]['cID'] = $res->getCollectionID();
                    }
                }else{
                    $cv_list[$res->getCollectionID()]['vObj'] = $cv->getPage(-1);
                    $cv_list[$res->getCollectionID()]['cName'] = $res->getCollectionName();
                    $cv_list[$res->getCollectionID()]['cID'] = $res->getCollectionID();
                }
            }
        }

        $cvl = new ItemList();
        $cvl->setItems($cv_list);
        $cvl->setItemsPerPage(10);
        $showPagination = false;
        if($cvl->getSummary()->pages > 1){
            $showPagination = true;
            $paginator = $cvl->getPagination();
        }
        $this->set('cParentID',$this->cParentID);
        $this->set('paginator',$paginator);
        $this->set('showPagination',$showPagination);
        $this->set('lastestversion', $this->lastestversion);
    
        $this->set('cvlresult',$cvl->getPage());
        $this->set('ptID', $this->ptID);
        $pagetypes = \PageType::getList();
        $this->set('pts',$pagetypes);

    }
    
    public function load_pagetype(){
        $this->view();
   }
}