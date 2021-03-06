<?php

namespace Config;

// Create a new instance of our RouteCollection class.
$routes = Services::routes();

// Load the system's routing file first, so that the app and ENVIRONMENT
// can override as needed.
if (file_exists(SYSTEMPATH . 'Config/Routes.php'))
{
	require SYSTEMPATH . 'Config/Routes.php';
}

/**
 * --------------------------------------------------------------------
 * Router Setup
 * --------------------------------------------------------------------
 */
$routes->setDefaultNamespace('App\Controllers');
$routes->setDefaultController('PageLoader');
$routes->setDefaultMethod('dashboard');
$routes->setTranslateURIDashes(false);
$routes->set404Override();
$routes->setAutoRoute(true);

/*
 * --------------------------------------------------------------------
 * Route Definitions
 * --------------------------------------------------------------------
 */

// We get a performance increase by specifying the default
// route since we don't have to scan directories.

// App Page Routes
$routes->get('/', 'PageLoader::dashboard');
$routes->get('login', 'PageLoader::login');
$routes->get("notices-mgt","PageLoader::notices_mgt");
$routes->get("add-new-notice","PageLoader::add_notice");
$routes->get("edit-notice/(:any)","PageLoader::edit_notice/$1");

// Employees
$routes->get("employee-mgt","PageLoader::employee_mgt");
$routes->get("add-new-employee","PageLoader::add_employee");
$routes->get("edit-employee/(:any)","PageLoader::edit_employee/$1");

// Auth EndPoints
$routes->post("login-exe","Authentication::login");
$routes->get("logout-exe","Authentication::logout");

// Notices
$routes->post("create-notice-exe","Notices::create_notice_exe");
$routes->post("delete-notice-exe","Notices::delete_notice_exe");
$routes->post("update-notice-exe","Notices::update_notice_exe");

// Employees
$routes->post("create-employee-exe","Employees::create_employee_exe");
$routes->post("delete-employee-exe","Employees::delete_employee_exe");
$routes->post("update-employee-exe","Employees::update_employee_exe");

// Employee Page Routes
$routes->get("my-notices","PageLoader::department_notices");
$routes->get("edit-profile","PageLoader::edit_profile");
$routes->post("update-profile-exe","Employees::update_profile_exe");
$routes->get("my-tasks","PageLoader::my_tasks");
$routes->get("task-details/(:any)","PageLoader::task_details/$1");

// Tasks
$routes->post("create-task-exe","Tasks::create_task_exe");
$routes->post("delete-task-exe","Tasks::delete_task_exe");
$routes->post("update-task-exe","Tasks::update_task_exe");

$routes->post("add-comment-to-task-api","Tasks::add_comment");

$routes->get("test-meeting","PageLoader::test_meeting");

$routes->get("tasks-mgt","PageLoader::tasks_mgt");
$routes->get("add-new-task","PageLoader::add_task");
$routes->get("edit-task/(:any)","PageLoader::edit_task/$1");

$routes->post("task-file-delete-api","PageLoader::task_file_delete_api");

$routes->get("manage-meetings","PageLoader::manage_meetings");
$routes->get("add-new-meeting","PageLoader::add_new_meeting");

$routes->post("create-meeting-exe","Meetings::create");

$routes->get("meeting/(:any)","PageLoader::meeting_page/$1");

/*
 * --------------------------------------------------------------------
 * Additional Routing
 * --------------------------------------------------------------------
 *
 * There will often be times that you need additional routing and you
 * need it to be able to override any defaults in this file. Environment
 * based routes is one such time. require() additional route files here
 * to make that happen.
 *
 * You will have access to the $routes object within that file without
 * needing to reload it.
 */
if (file_exists(APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php'))
{
	require APPPATH . 'Config/' . ENVIRONMENT . '/Routes.php';
}
