<?php
/**
 * The Orno Component Library
 *
 * @author  Phil Bennett @philipobenito
 * @license MIT (see the LICENSE file)
 */
namespace Orno\Http\Exception;

use Orno\Http\Exception as HttpException;

class UnauthorizedException extends HttpException
{
    /**
     * Constructor
     *
     * @param string     $message
     * @param \Exception $previous
     * @param integer    $code
     */
    public function __construct($message = 'Unauthorized', \Exception $previous = null, $code = 0)
    {
        parent::__construct(401, $message, $previous, [], $code);
    }
}
