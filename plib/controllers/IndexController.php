<?php
// Copyright 1999-2019. Plesk International GmbH. All Rights Reserved.

class IndexController extends pm_Controller_Action
{
    protected $_accessLevel = 'admin';

    public function init()
    {
        parent::init();

        $this->view->pageTitle = $this->lmsg('pageTitle');
    }

    public function indexAction()
    {
        $form = new pm_Form_Simple();
        $form->addElement('text', 'myStartPageLink', ['label' => $this->lmsg('formMyStartPageLink'), 'value' => pm_Settings::get('myStartPageLink'), 'style' => 'width: 40%;']);
        $form->addControlButtons(['cancelLink' => pm_Context::getModulesListUrl(),]);

        if ($this->getRequest()->isPost() && $form->isValid($this->getRequest()->getPost())) {
            $myStartPageLink = $form->getValue('myStartPageLink') ?? '';
            pm_Settings::set('myStartPageLink', $myStartPageLink);

            if (!empty($myStartPageLink)) {
                $_SESSION['myStartPageRedirect'] = true;
            }

            $this->_status->addMessage('info', $this->lmsg('messageSuccess'));
            $this->_helper->json(['redirect' => pm_Context::getBaseUrl()]);
        }

        $this->view->form = $form;
        $this->view->outputDescription = $this->lmsg('pageTitleDescription');
    }
}