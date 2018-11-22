<?php

namespace CodeProject\Http\Middleware;

use Closure;
use CodeProject\Repositories\ProjectRepository;
use Symfony\Component\HttpFoundation\Response;

class CheckProjectOwner {

  /**
   * @var ProjectRepository
   */
  private $repository;

  public function __construct(ProjectRepository $repository) {

    $this->repository = $repository;
  }

  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request $request
   * @param  \Closure $next
   * @return mixed
   */
  public function handle($request, Closure $next) {




    return $next($request);
  }
}
