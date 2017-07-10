<?php
namespace DRCSystems\NewsComment\Utility\Validator;

use TYPO3\CMS\Extbase\Utility\LocalizationUtility;
use TYPO3\CMS\Core\Utility\GeneralUtility;

/**
 * validate reservation form
 *
 */
class CustomValidator extends \TYPO3\CMS\Extbase\Validation\Validator\AbstractValidator {

	/**
	 * @var \TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface
	 * @inject
	 */
	protected $configurationManager;

	/**
	 * Check if $value is valid. If it is not valid, needs to add an error
	 * to Result.
	 *
	 * @param \DRCSystems\NewsComment\Utility\Validator\CustomValidator $newComment
	 *
	 * @return void
	 */
	protected function isValid($newComment) {

		$translateArguments = array(
            'username' => $newComment->getUsername(),
            'usermail' => $newComment->getUsermail(),
            'description' => $newComment->getDescription()
        );

		$userName =  $newComment->getUsername(); 
		$usermail =  $newComment->getUsermail(); 
		$commentText =  $newComment->getDescription(); 
		$this->settings = $this->getPluginSettings();

		if($userName == '' || $usermail == '' || trim($commentText) == '')
		{
			$msg = LocalizationUtility::translate('tx_newscomment_domain_model_comment.require_field_msg', 'NewsComment', $translateArguments);
            $this->addError($msg, 1221560718);
            return;
		}

		if(!(GeneralUtility::validEmail($usermail)))
		{
			$msg = LocalizationUtility::translate('tx_newscomment_domain_model_comment.valid_email_msg', 'NewsComment', $translateArguments);
            $this->addError($msg, 1221559976);
            return;
		}
		if ($this->checkBadWord($commentText)) {
            $msg = LocalizationUtility::translate('tx_newscomment_domain_model_comment.badwordfound_msg', 'NewsComment', $translateArguments);
            $this->addError($msg, 1406644911);
            return;
        } 
        return;
	}

	/**
	 * Returns the plugin settings
	 *
	 * @return array rendered typoscript settings
	 */
	protected function getPluginSettings() {
		$fullTyposcript = $this->configurationManager->getConfiguration(
			\TYPO3\CMS\Extbase\Configuration\ConfigurationManagerInterface::CONFIGURATION_TYPE_FULL_TYPOSCRIPT
		);
		$extensionTyposcript = $fullTyposcript['plugin.']['tx_newscomment_newscomment.']['settings.'];

		return($extensionTyposcript); 
	}

	protected function checkBadWord($commentText)
	{
		$badWords = $this->settings['badwordFilterString'];  
        $badWordsList = explode(',', $badWords);
        foreach ($badWordsList as $key => $value) {
        	if(trim($value) != '' && $commentText != ''){
	            $pos = strpos($commentText, trim($value));
	            if ($pos === false) {} else {
					return true;
	            }
        	}
        } 
        return false;
	}
	
}