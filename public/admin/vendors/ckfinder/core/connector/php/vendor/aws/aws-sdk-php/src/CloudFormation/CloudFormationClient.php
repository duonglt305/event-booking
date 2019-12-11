<?php
namespace Aws\CloudFormation;

use Aws\AwsClient;
use Aws\Result;
use GuzzleHttp\Promise\Promise;

/**
 * This client is used to interact with the **AWS CloudFormation** service.
 *
 * @method Result cancelUpdateStack(array $args = [])
 * @method Promise cancelUpdateStackAsync(array $args = [])
 * @method Result continueUpdateRollback(array $args = [])
 * @method Promise continueUpdateRollbackAsync(array $args = [])
 * @method Result createChangeSet(array $args = [])
 * @method Promise createChangeSetAsync(array $args = [])
 * @method Result createStack(array $args = [])
 * @method Promise createStackAsync(array $args = [])
 * @method Result createStackInstances(array $args = [])
 * @method Promise createStackInstancesAsync(array $args = [])
 * @method Result createStackSet(array $args = [])
 * @method Promise createStackSetAsync(array $args = [])
 * @method Result deleteChangeSet(array $args = [])
 * @method Promise deleteChangeSetAsync(array $args = [])
 * @method Result deleteStack(array $args = [])
 * @method Promise deleteStackAsync(array $args = [])
 * @method Result deleteStackInstances(array $args = [])
 * @method Promise deleteStackInstancesAsync(array $args = [])
 * @method Result deleteStackSet(array $args = [])
 * @method Promise deleteStackSetAsync(array $args = [])
 * @method Result describeAccountLimits(array $args = [])
 * @method Promise describeAccountLimitsAsync(array $args = [])
 * @method Result describeChangeSet(array $args = [])
 * @method Promise describeChangeSetAsync(array $args = [])
 * @method Result describeStackDriftDetectionStatus(array $args = [])
 * @method Promise describeStackDriftDetectionStatusAsync(array $args = [])
 * @method Result describeStackEvents(array $args = [])
 * @method Promise describeStackEventsAsync(array $args = [])
 * @method Result describeStackInstance(array $args = [])
 * @method Promise describeStackInstanceAsync(array $args = [])
 * @method Result describeStackResource(array $args = [])
 * @method Promise describeStackResourceAsync(array $args = [])
 * @method Result describeStackResourceDrifts(array $args = [])
 * @method Promise describeStackResourceDriftsAsync(array $args = [])
 * @method Result describeStackResources(array $args = [])
 * @method Promise describeStackResourcesAsync(array $args = [])
 * @method Result describeStackSet(array $args = [])
 * @method Promise describeStackSetAsync(array $args = [])
 * @method Result describeStackSetOperation(array $args = [])
 * @method Promise describeStackSetOperationAsync(array $args = [])
 * @method Result describeStacks(array $args = [])
 * @method Promise describeStacksAsync(array $args = [])
 * @method Result detectStackDrift(array $args = [])
 * @method Promise detectStackDriftAsync(array $args = [])
 * @method Result detectStackResourceDrift(array $args = [])
 * @method Promise detectStackResourceDriftAsync(array $args = [])
 * @method Result estimateTemplateCost(array $args = [])
 * @method Promise estimateTemplateCostAsync(array $args = [])
 * @method Result executeChangeSet(array $args = [])
 * @method Promise executeChangeSetAsync(array $args = [])
 * @method Result getStackPolicy(array $args = [])
 * @method Promise getStackPolicyAsync(array $args = [])
 * @method Result getTemplate(array $args = [])
 * @method Promise getTemplateAsync(array $args = [])
 * @method Result getTemplateSummary(array $args = [])
 * @method Promise getTemplateSummaryAsync(array $args = [])
 * @method Result listChangeSets(array $args = [])
 * @method Promise listChangeSetsAsync(array $args = [])
 * @method Result listExports(array $args = [])
 * @method Promise listExportsAsync(array $args = [])
 * @method Result listImports(array $args = [])
 * @method Promise listImportsAsync(array $args = [])
 * @method Result listStackInstances(array $args = [])
 * @method Promise listStackInstancesAsync(array $args = [])
 * @method Result listStackResources(array $args = [])
 * @method Promise listStackResourcesAsync(array $args = [])
 * @method Result listStackSetOperationResults(array $args = [])
 * @method Promise listStackSetOperationResultsAsync(array $args = [])
 * @method Result listStackSetOperations(array $args = [])
 * @method Promise listStackSetOperationsAsync(array $args = [])
 * @method Result listStackSets(array $args = [])
 * @method Promise listStackSetsAsync(array $args = [])
 * @method Result listStacks(array $args = [])
 * @method Promise listStacksAsync(array $args = [])
 * @method Result setStackPolicy(array $args = [])
 * @method Promise setStackPolicyAsync(array $args = [])
 * @method Result signalResource(array $args = [])
 * @method Promise signalResourceAsync(array $args = [])
 * @method Result stopStackSetOperation(array $args = [])
 * @method Promise stopStackSetOperationAsync(array $args = [])
 * @method Result updateStack(array $args = [])
 * @method Promise updateStackAsync(array $args = [])
 * @method Result updateStackInstances(array $args = [])
 * @method Promise updateStackInstancesAsync(array $args = [])
 * @method Result updateStackSet(array $args = [])
 * @method Promise updateStackSetAsync(array $args = [])
 * @method Result updateTerminationProtection(array $args = [])
 * @method Promise updateTerminationProtectionAsync(array $args = [])
 * @method Result validateTemplate(array $args = [])
 * @method Promise validateTemplateAsync(array $args = [])
 */
class CloudFormationClient extends AwsClient {}
