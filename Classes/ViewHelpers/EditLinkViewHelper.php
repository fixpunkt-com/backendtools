<?php

namespace Fixpunkt\Backendtools\ViewHelpers;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;

class EditLinkViewHelper extends AbstractTagBasedViewHelper
{
    /**
     * @var string
     */
    protected $tagName = 'a';

    /**
     * renders <ex:editLink>
     * Crafts a link to edit a database record or create a new one
     *
     * @return string The <a> tag
     * @see \TYPO3\CMS\Backend\Utility::editOnClick()
     */
    public function render(): string
    {
        // Edit all icon:
        $urlParameters = [
            'edit' => [
                $this->additionalArguments['table'] => [
                    $this->additionalArguments['uid'] => $this->additionalArguments['action'],
                ],
            ],
            'columnsOnly' => '',
            'createExtension' => 0,
        ];
        if ($this->additionalArguments['language'] > 0) {
            $urlParameters['overrideVals']['pages']['sys_language_uid'] = $this->additionalArguments['language'];
        }
        $urlParameters['returnUrl'] = GeneralUtility::getIndpEnv('REQUEST_URI');
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uri = $uriBuilder->buildUriFromRoute('record_edit', $urlParameters);

        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($this->renderChildren());
        $this->tag->forceClosingTag(true);
        return $this->tag->render();
    }
}
