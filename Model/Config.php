<?php
namespace Worldpay\Payments\Model;

use Magento\Framework\Serialize\Serializer\Json as Serialize;
use Magento\Store\Model\ScopeInterface;

class Config
{
    /**
     * @var \Magento\Framework\App\Config\ScopeConfigInterface
     */
    protected $_scopeConfigInterface;
    protected $customerSession;
    private $serialize;

    public function __construct(
    \Magento\Framework\App\Config\ScopeConfigInterface $configInterface,
    \Magento\Customer\Model\Session $customerSession,
    \Magento\Backend\Model\Session\Quote $sessionQuote,
    Serialize $serialize
    )
    {
        $this->_scopeConfigInterface = $configInterface;
        $this->customerSession = $customerSession;
        $this->sessionQuote = $sessionQuote;
        $this->serialize = $serialize;
    }

    public function isLiveMode($scope = ScopeInterface::SCOPE_WEBSITE) {
        return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/mode', $scope) == 'live_mode';
    }

    public function isAuthorizeOnly($scope = ScopeInterface::SCOPE_WEBSITE) {
        return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/payment_action', $scope) == 'authorize';
    }

    public function saveCard($scope = ScopeInterface::SCOPE_WEBSITE) {
        return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/save_card', $scope) && ($this->customerSession->isLoggedIn() || $this->sessionQuote->getCustomerId());
    }

    public function threeDSEnabled($scope = ScopeInterface::SCOPE_WEBSITE) {
        return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/threeds_enabled', $scope);
    }

    public function getClientKey($scope = ScopeInterface::SCOPE_WEBSITE)
    {
        if ($this->isLiveMode()) {
            return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/live_client_key', $scope);
        } else {
            return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/test_client_key', $scope);
        }
    }

    public function getServiceKey($scope = ScopeInterface::SCOPE_WEBSITE, $code = null)
    {
        if ($code)
        {
            if ($this->isLiveMode()) {
                return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/live_service_key', $scope, $code);
            } else {
                return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/test_service_key', $scope, $code);
            }
        }
        else
        {
            if ($this->isLiveMode()) {
                return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/live_service_key', $scope);
            } else {
                return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/test_service_key', $scope);
            }
        }
    }

    public function getSettlementCurrency($scope = ScopeInterface::SCOPE_WEBSITE) {
        return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/settlement_currency', $scope);
    }

    public function debugMode($code) {
        return !!$this->_scopeConfigInterface->getValue('payment/'. $code .'/debug');
    }

    public function getPaymentDescription($scope = ScopeInterface::SCOPE_WEBSITE) {
        return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/payment_description', $scope);
    }

    public function getLanguageCode($scope = ScopeInterface::SCOPE_WEBSITE) {
        return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/language_code', $scope);
    }

    public function getShopCountryCode($scope = ScopeInterface::SCOPE_WEBSITE) {
        return $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/shop_country_code', $scope);
    }

    public function getSitecodes($scope = ScopeInterface::SCOPE_WEBSITE) {
        $sitecodeConfig = $this->_scopeConfigInterface->getValue('payment/worldpay_payments_card/sitecodes', $scope);
        if ($sitecodeConfig) {
            //$siteCodes = unserialize($sitecodeConfig);
            $siteCodes = $this->serialize->unserialize($sitecodeConfig);
            if (is_array($siteCodes)) {
                return $siteCodes;
            }
        }
        return false;
    }
}