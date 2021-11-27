<?php

namespace App\Http\Controllers;

use App\DTO\LotMetaDTO;
use App\Http\Requests\LotRequest;
use App\Http\Requests\LotTradeRequest;
use App\Models\Lot;
use App\Resources\LotResource;
use Auth;
use Cache;
use Carbon\Carbon;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Resources\Json\JsonResource;
use Spatie\QueryBuilder\AllowedFilter;
use Spatie\QueryBuilder\QueryBuilder;

class LotController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Lot::class, 'lot');
    }

    public function index(): JsonResource
    {
        return LotResource::collection(
            QueryBuilder::for(Lot::class)
                ->allowedFilters([
                    AllowedFilter::exact('id'),
                    AllowedFilter::exact('name'),
                    AllowedFilter::exact('user_id'),
                ])
                ->with(['user', 'product'])
                ->paginate()
        );
    }

    public function show(Lot $lot): JsonResource
    {
        return new LotResource($lot);
    }

    public function store(LotRequest $request): JsonResource
    {
        return new LotResource(Lot::create(array_merge($request->validated(), [
            'user_id' => Auth::user()->id,
            'meta' => LotMetaDTO::defaults(),
        ])));
    }

    public function update(Lot $lot, LotRequest $request): JsonResource|JsonResponse
    {
        if ($lot->started_at < Carbon::now()) {
            return $this->respondFailedValidation(trans('validation.lots.non_editable'));
        }

        $lot->update($request->validated());

        return new LotResource($lot);
    }

    public function destroy(Lot $lot): JsonResponse
    {
        $lot->deleteOrFail();

        return $this->respondWithSuccess();
    }

    public function trade(Lot $lot, LotTradeRequest $request): JsonResponse
    {
        $this->authorize('trade', $lot);

        if (!$lot->isOpened()) {
            return $this->respondFailedValidation(trans('validation.lots.trade.invalid_status'));
        }

        Cache::lock($lot->getLockKey('trade'))->get(function () use ($lot, $request): void {
            $lot->update([
                'buyer_id' => Auth::user()->id,
                'price' => $request->validated()['price'],
            ]);
        });

        return $this->respondWithSuccess();
    }
}
