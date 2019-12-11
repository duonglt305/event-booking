<?php
namespace Aws\LexRuntimeService;

use Aws\AwsClient;
use Aws\Result;
use GuzzleHttp\Promise\Promise;

/**
 * This client is used to interact with the **Amazon Lex Runtime Service** service.
 * @method Result postContent(array $args = [])
 * @method Promise postContentAsync(array $args = [])
 * @method Result postText(array $args = [])
 * @method Promise postTextAsync(array $args = [])
 */
class LexRuntimeServiceClient extends AwsClient {}
