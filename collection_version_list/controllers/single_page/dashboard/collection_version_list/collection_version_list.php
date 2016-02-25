<?
namespace Concrete\Package\CollectionVersionList\Controller\SinglePage\Dashboard;
use \Concrete\Core\Page\Controller\DashboardPageController;
class CollectionVersionList extends DashboardPageController {

	public function view() {
		$this->redirect('/dashboard/collection_version_list/search');
	}

	
}
