<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use App\Helpers\Helpers as Helper;

class EnsureUserLogin
{
  /**
   * Handle an incoming request.
   *
   * @param  \Illuminate\Http\Request  $request
   * @param  \Closure(\Illuminate\Http\Request): (\Illuminate\Http\Response|\Illuminate\Http\RedirectResponse)  $next
   * @return \Illuminate\Http\Response|\Illuminate\Http\RedirectResponse
   */
  public function handle(Request $request, Closure $next)
  {
    if (session()->has('username')) {

      $menu_arr = Helper::get_menu_access(session()->get('username'));
      $menu_active = session('menu_active', '');
      $currentRouteName = \Route::currentRouteName();

      $verticalMenuJson = file_get_contents(base_path('resources/menu/verticalMenu.json'));
      $verticalMenuData = json_decode($verticalMenuJson);
      $netral_menu = array(
        'pages-home',
        'pages-portal',
        'auth-notif',
        'pages-finance',
        'pages-edit-data-event',
        'print-approval-event',
        'input-banner',
        'edit-status-banner',
        'edit-status-calendar',
        'pricelists',
        'template-import-pricelist',
        'template-export-pricelist',
      );

      //return $next($request);

      //var_dump($currentRouteName);


      if ($menu_active == 'marketing') {

        $ver_slug = array();
        $has_access = false;

        if (in_array($currentRouteName, $menu_arr) || in_array($currentRouteName, $netral_menu)) {
          return $next($request);
        } else {

          foreach ($verticalMenuData->menu as $menus) {

            if (in_array($menus->slug, $menu_arr)) {

              if (isset($menus->submenu)) {

                if (is_array($menus->submenu)) {
                  if (count($menus->submenu) > 0) {

                    foreach ($menus->submenu as $submenus) {

                      if ($submenus->slug == $currentRouteName && $submenus->slug != "event-new") {
                        $has_access = true;
                        return $next($request);
                      }
                    }
                  }
                }
              }
            }
          }

          if (!$has_access) {
            $err_msg = 'Anda Tidak Memiliki akses.';
            redirect()->route('auth-notif', ['msg' => $err_msg, 'type' => 'warning', 'redir' => route('pages-home')])->send();
          }
        }
      } else {
        return $next($request);
      }
    } else {

      $err_msg = 'Anda belum login.';
      redirect()->route('auth-login', ['login_msg' => $err_msg])->send();
    }
  }
}
