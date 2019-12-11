<?php
namespace Aws\Route53Domains;

use Aws\AwsClient;
use Aws\Result;
use GuzzleHttp\Promise\Promise;

/**
 * This client is used to interact with the **Amazon Route 53 Domains** service.
 *
 * @method Result checkDomainAvailability(array $args = [])
 * @method Promise checkDomainAvailabilityAsync(array $args = [])
 * @method Result checkDomainTransferability(array $args = [])
 * @method Promise checkDomainTransferabilityAsync(array $args = [])
 * @method Result deleteTagsForDomain(array $args = [])
 * @method Promise deleteTagsForDomainAsync(array $args = [])
 * @method Result disableDomainAutoRenew(array $args = [])
 * @method Promise disableDomainAutoRenewAsync(array $args = [])
 * @method Result disableDomainTransferLock(array $args = [])
 * @method Promise disableDomainTransferLockAsync(array $args = [])
 * @method Result enableDomainAutoRenew(array $args = [])
 * @method Promise enableDomainAutoRenewAsync(array $args = [])
 * @method Result enableDomainTransferLock(array $args = [])
 * @method Promise enableDomainTransferLockAsync(array $args = [])
 * @method Result getContactReachabilityStatus(array $args = [])
 * @method Promise getContactReachabilityStatusAsync(array $args = [])
 * @method Result getDomainDetail(array $args = [])
 * @method Promise getDomainDetailAsync(array $args = [])
 * @method Result getDomainSuggestions(array $args = [])
 * @method Promise getDomainSuggestionsAsync(array $args = [])
 * @method Result getOperationDetail(array $args = [])
 * @method Promise getOperationDetailAsync(array $args = [])
 * @method Result listDomains(array $args = [])
 * @method Promise listDomainsAsync(array $args = [])
 * @method Result listOperations(array $args = [])
 * @method Promise listOperationsAsync(array $args = [])
 * @method Result listTagsForDomain(array $args = [])
 * @method Promise listTagsForDomainAsync(array $args = [])
 * @method Result registerDomain(array $args = [])
 * @method Promise registerDomainAsync(array $args = [])
 * @method Result renewDomain(array $args = [])
 * @method Promise renewDomainAsync(array $args = [])
 * @method Result resendContactReachabilityEmail(array $args = [])
 * @method Promise resendContactReachabilityEmailAsync(array $args = [])
 * @method Result retrieveDomainAuthCode(array $args = [])
 * @method Promise retrieveDomainAuthCodeAsync(array $args = [])
 * @method Result transferDomain(array $args = [])
 * @method Promise transferDomainAsync(array $args = [])
 * @method Result updateDomainContact(array $args = [])
 * @method Promise updateDomainContactAsync(array $args = [])
 * @method Result updateDomainContactPrivacy(array $args = [])
 * @method Promise updateDomainContactPrivacyAsync(array $args = [])
 * @method Result updateDomainNameservers(array $args = [])
 * @method Promise updateDomainNameserversAsync(array $args = [])
 * @method Result updateTagsForDomain(array $args = [])
 * @method Promise updateTagsForDomainAsync(array $args = [])
 * @method Result viewBilling(array $args = [])
 * @method Promise viewBillingAsync(array $args = [])
 */
class Route53DomainsClient extends AwsClient {}
