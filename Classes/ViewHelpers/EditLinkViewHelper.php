<?php

namespace Fixpunkt\Backendtools\ViewHelpers;

use TYPO3\CMS\Backend\Routing\UriBuilder;
use TYPO3\CMS\Core\Utility\GeneralUtility;
use TYPO3Fluid\Fluid\Core\ViewHelper\AbstractTagBasedViewHelper;
use Psr\Http\Message\ServerRequestInterface;

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
        $request = $this->getRequest();
        /** @var \TYPO3\CMS\Core\Http\NormalizedParams $normalizedParams */
        $normalizedParams = $request->getAttribute('normalizedParams');

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
        if (isset($this->additionalArguments['language']) && $this->additionalArguments['language'] > 0) {
            $urlParameters['overrideVals']['pages']['sys_language_uid'] = $this->additionalArguments['language'];
        }
        // deprecated: $urlParameters['returnUrl'] = GeneralUtility::getIndpEnv('REQUEST_URI');
        $urlParameters['returnUrl'] = $normalizedParams->getRequestUri();
        $uriBuilder = GeneralUtility::makeInstance(UriBuilder::class);
        $uri = $uriBuilder->buildUriFromRoute('record_edit', $urlParameters);

        $this->tag->addAttribute('href', $uri);
        $this->tag->setContent($this->renderChildren());
        $this->tag->forceClosingTag(true);
        return $this->tag->render();
    }

    private function getRequest(): ServerRequestInterface|null
    {
        if ($this->renderingContext->hasAttribute(ServerRequestInterface::class)) {
            return $this->renderingContext->getAttribute(ServerRequestInterface::class);
        }
        return null;
    }
}
