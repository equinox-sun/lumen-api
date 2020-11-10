<?php


namespace App\Events;


use App\Repositories\Enums\LogEnum;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response as SymfonyResponse;

class RequestHandled extends Event
{
    public function __construct(Request $request, $response)
    {
        if (config('logging.request.enabled')) {
            $start = $request->server('REQUEST_TIME_FLOAT');
            $end = microtime(true);
            $context = [
                'request' => $request->all(),
                'response' => $response instanceof SymfonyResponse ? json_decode($response->getContent(), true) : (string) $response,
                'start' => $start,
                'end' => $end,
                'duration' => formatDuration($end - $start)
            ];

            logger(LogEnum::LOG_REQUEST_TIME, $context);
        }
    }
}
