<?php namespace Impero\Apache\Controller;

use Impero\Apache\Entity\Sites;
use Impero\Apache\Form\Site as SiteForm;
use Impero\Apache\Record\Site as SiteRecord;
use Pckg\Database\Helper\Traits;
use Pckg\Framework\Response;

class Apache
{

    use Traits;

    public function getIndexAction(Sites $sites)
    {
        return view('index', [
            'sites' => $sites->all(),
        ]);
    }

    public function getAddAction(SiteForm $siteForm, SiteRecord $siteRecord)
    {
        $siteForm->useRecordDatasource()
            ->setRecord($siteRecord);

        return view('add', [
            'siteForm' => $siteForm,
        ]);
    }

    public function postAddAction(SiteForm $siteForm, SiteRecord $siteRecord)
    {
        $siteForm->useRecordDatasource()
            ->setRecord($siteRecord);

        $siteRecord->user_id = $this->auth()->getUser()->id;

        return $this->response()->redirect();
    }

    /**
     * @param SiteForm   $siteForm Automatically bound without requirement
     * @param SiteRecord $siteRecord Resolved ;-)
     */
    public function getEditAction(SiteForm $siteForm, SiteRecord $siteRecord)
    {
        $siteForm->useRecordDatasource()
            ->setRecord($siteRecord);

        return view('edit', [
            'siteForm' => $siteForm,
        ]);
    }

    public function postEditAction(SiteForm $siteForm, SiteRecord $siteRecord)
    {
        $siteForm->useRecordDatasource()
            ->setRecord($siteRecord);

        return $this->response()->redirect();
    }

}