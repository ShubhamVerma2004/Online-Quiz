<?php
    include_once 'database.php';
    session_start();
    if(!(isset($_SESSION['email'])))
    {
        header("location:login.php");
    }
    else
    {
        $name = $_SESSION['name'];
        $email = $_SESSION['email'];
        include_once 'database.php';
    }
?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Dashboard | QuizMaster Admin</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/css/bootstrap.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        :root {
            --primary: #6c5ce7;
            --primary-dark: #5649c0;
            --secondary: #fd79a8;
            --dark: #2d3436;
            --light: #f5f6fa;
            --success: #00b894;
            --danger: #d63031;
            --warning: #fdcb6e;
            --info: #0984e3;
            --gray: #636e72;
            --light-gray: #dfe6e9;
        }

        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: 'Poppins', sans-serif;
        }

        body {
            background-color: #f8f9fa;
            color: var(--dark);
            overflow-x: hidden;
        }

        /* Sidebar Styles */
        .sidebar {
            position: fixed;
            top: 0;
            left: 0;
            width: 280px;
            height: 100vh;
            background: linear-gradient(180deg, var(--primary), var(--primary-dark));
            color: white;
            padding: 20px 0;
            transition: all 0.3s ease;
            z-index: 1000;
            box-shadow: 5px 0 15px rgba(0,0,0,0.1);
        }

        .sidebar.collapsed {
            width: 80px;
        }

        .sidebar.collapsed .sidebar-header h3,
        .sidebar.collapsed .nav-link span {
            display: none;
        }

        .sidebar.collapsed .nav-link {
            justify-content: center;
            padding: 12px 0;
        }

        .sidebar.collapsed .nav-link i {
            margin-right: 0;
            font-size: 1.3rem;
        }

        .sidebar-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            padding: 0 20px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.1);
        }

        .sidebar-header h3 {
            font-weight: 600;
            font-size: 1.3rem;
            margin-bottom: 0;
        }

        .toggle-btn {
            background: none;
            border: none;
            color: white;
            font-size: 1.2rem;
            cursor: pointer;
            transition: all 0.3s ease;
            padding: 5px;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .toggle-btn:hover {
            background-color: rgba(255,255,255,0.1);
            transform: rotate(180deg);
        }

        .sidebar-menu {
            padding: 20px 0;
            height: calc(100vh - 120px);
            overflow-y: auto;
        }

        .nav-item {
            margin-bottom: 5px;
            position: relative;
        }

        .nav-link {
            display: flex;
            align-items: center;
            padding: 12px 20px;
            color: rgba(255,255,255,0.8);
            text-decoration: none;
            transition: all 0.3s ease;
            border-left: 3px solid transparent;
        }

        .nav-link:hover {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left: 3px solid var(--secondary);
        }

        .nav-link.active {
            color: white;
            background: rgba(255,255,255,0.1);
            border-left: 3px solid var(--secondary);
        }

        .nav-link i {
            margin-right: 15px;
            font-size: 1.1rem;
            transition: all 0.3s ease;
        }

        .nav-link.active i {
            transform: scale(1.1);
        }

        /* Main Content Styles */
        .main-content {
            margin-left: 280px;
            min-height: 100vh;
            transition: all 0.3s ease;
            background-color: #f8f9fa;
        }

        .sidebar.collapsed + .main-content {
            margin-left: 80px;
        }

        /* Top Navbar Styles */
        .top-navbar {
            background: white;
            padding: 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.05);
            position: sticky;
            top: 0;
            z-index: 100;
            width: 100%;
        }

        .navbar-container {
            display: flex;
            align-items: center;
            padding: 10px 25px;
            width: 100%;
        }

        .navbar-content {
            display: flex;
            align-items: center;
            justify-content: space-between;
            width: 100%;
        }

        .search-box-container {
            flex-grow: 1;
            max-width: 500px;
            margin-right: 15px;
        }

        .user-menu-container {
            flex-shrink: 0;
        }

        .search-box {
            position: relative;
            width: 100%;
            max-width: 300px;
            margin: 0 auto;
        }

        .search-box input {
            width: 100%;
            padding: 8px 15px 8px 40px;
            border: 1px solid var(--light-gray);
            border-radius: 30px;
            outline: none;
            transition: all 0.3s ease;
            font-size: 0.9rem;
        }

        .search-box input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
        }

        .search-box i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: var(--gray);
            font-size: 0.9rem;
        }

        .user-menu {
            display: flex;
            align-items: center;
        }

        .user-menu .dropdown-toggle {
            display: flex;
            align-items: center;
            background: none;
            border: none;
            color: var(--dark);
            cursor: pointer;
            white-space: nowrap;
            overflow: hidden;
            text-overflow: ellipsis;
            max-width: 200px;
            padding: 5px 10px;
            border-radius: 30px;
            transition: all 0.3s ease;
        }

        .user-menu .dropdown-toggle:hover {
            background-color: rgba(0,0,0,0.05);
        }

        .user-menu .user-img {
            width: 40px;
            height: 40px;
            border-radius: 50%;
            margin-right: 10px;
            object-fit: cover;
            background: var(--primary);
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-weight: 600;
            text-transform: uppercase;
        }

        .user-menu .user-name {
            margin-right: 10px;
            font-weight: 500;
            font-size: 0.9rem;
        }

        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 5px 0;
            min-width: 200px;
            margin-top: 5px;
        }

        .dropdown-item {
            padding: 8px 20px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }

        .dropdown-item:hover {
            background-color: var(--light);
            color: var(--primary);
        }

        .dropdown-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            font-size: 0.9rem;
        }

        .dropdown-divider {
            margin: 5px 0;
            border-color: rgba(0,0,0,0.05);
        }

        /* Content Area */
        .content-area {
            padding: 30px;
        }

        .page-header {
            display: flex;
            align-items: center;
            justify-content: space-between;
            margin-bottom: 30px;
        }

        .page-title {
            font-size: 1.8rem;
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 0;
        }

        .breadcrumb {
            background: none;
            padding: 0;
            margin-bottom: 0;
            display: flex;
            align-items: center;
            flex-wrap: wrap;
        }

        .breadcrumb-item {
            font-size: 0.9rem;
        }

        .breadcrumb-item a {
            color: var(--primary);
            text-decoration: none;
            transition: all 0.3s ease;
        }

        .breadcrumb-item a:hover {
            color: var(--primary-dark);
            text-decoration: underline;
        }

        .breadcrumb-item.active {
            color: var(--gray);
        }

        .breadcrumb-item + .breadcrumb-item::before {
            content: '›';
            padding: 0 10px;
            color: var(--gray);
        }

        /* Cards */
        .card {
            border: none;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.05);
            margin-bottom: 30px;
            transition: all 0.3s ease;
            overflow: hidden;
            background: white;
        }

        .card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.1);
        }

        .card-header {
            background: white;
            border-bottom: 1px solid rgba(0,0,0,0.05);
            padding: 15px 20px;
            display: flex;
            align-items: center;
            justify-content: space-between;
            flex-wrap: wrap;
        }

        .card-title {
            font-size: 1.2rem;
            font-weight: 600;
            margin-bottom: 0;
            color: var(--dark);
        }

        .card-body {
            padding: 20px;
        }

        /* Stats Cards */
        .stats-card {
            text-align: center;
            padding: 20px;
            border-radius: 10px;
            color: white;
            position: relative;
            overflow: hidden;
            transition: all 0.3s ease;
            height: 100%;
        }

        .stats-card::before {
            content: '';
            position: absolute;
            top: -50px;
            right: -50px;
            width: 100px;
            height: 100px;
            border-radius: 50%;
            background: rgba(255,255,255,0.1);
        }

        .stats-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.1);
        }

        .stats-card .icon {
            font-size: 2.5rem;
            margin-bottom: 15px;
            opacity: 0.8;
        }

        .stats-card .stats-title {
            font-size: 1rem;
            margin-bottom: 5px;
            opacity: 0.8;
        }

        .stats-card .stats-value {
            font-size: 1.8rem;
            font-weight: 600;
            margin-bottom: 10px;
        }

        .stats-card .stats-change {
            font-size: 0.9rem;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .stats-card .stats-change i {
            margin-right: 5px;
        }

        .stats-card.primary {
            background: linear-gradient(135deg, var(--primary), var(--primary-dark));
        }

        .stats-card.success {
            background: linear-gradient(135deg, var(--success), #00a884);
        }

        .stats-card.warning {
            background: linear-gradient(135deg, var(--warning), #fdc14a);
        }

        .stats-card.danger {
            background: linear-gradient(135deg, var(--danger), #c0392b);
        }

        /* Tables */
        .table-responsive {
            border-radius: 10px;
            overflow: hidden;
            box-shadow: 0 0 10px rgba(0,0,0,0.05);
        }

        .table {
            margin-bottom: 0;
            width: 100%;
            font-size: 0.9rem;
        }

        .table thead th {
            background-color: var(--primary);
            color: white;
            border: none;
            padding: 15px;
            font-weight: 500;
            text-align: left;
            vertical-align: middle;
        }

        .table tbody tr {
            transition: all 0.3s ease;
            background: white;
        }

        .table tbody tr:nth-child(even) {
            background-color: #f9f9f9;
        }

        .table tbody tr:hover {
            background-color: rgba(108, 92, 231, 0.05);
        }

        .table tbody td {
            padding: 12px 15px;
            vertical-align: middle;
            border-top: 1px solid rgba(0,0,0,0.05);
        }

        .table .badge {
            padding: 6px 10px;
            font-weight: 500;
            border-radius: 30px;
            font-size: 0.75rem;
        }

        /* Buttons */
        .btn {
            padding: 8px 20px;
            border-radius: 30px;
            font-weight: 500;
            transition: all 0.3s ease;
            border: none;
            box-shadow: none;
            cursor: pointer;
            display: inline-flex;
            align-items: center;
            justify-content: center;
            font-size: 0.9rem;
            line-height: 1.5;
            text-decoration: none;
            position: relative;
            overflow: hidden;
        }

        .btn i {
            margin-right: 8px;
            font-size: 0.9rem;
        }

        .btn-sm {
            padding: 5px 15px;
            font-size: 0.8rem;
        }

        .btn-sm i {
            font-size: 0.8rem;
        }

        .btn-lg {
            padding: 10px 30px;
            font-size: 1rem;
        }

        .btn-lg i {
            font-size: 1rem;
        }

        .btn-primary {
            background-color: var(--primary);
            color: white;
        }

        .btn-primary:hover {
            background-color: var(--primary-dark);
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(108, 92, 231, 0.3);
        }

        .btn-outline-primary {
            background-color: transparent;
            border: 1px solid var(--primary);
            color: var(--primary);
        }

        .btn-outline-primary:hover {
            background-color: var(--primary);
            color: white;
            border-color: var(--primary);
        }

        .btn-success {
            background-color: var(--success);
            color: white;
        }

        .btn-success:hover {
            background-color: #00a884;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(0, 184, 148, 0.3);
        }

        .btn-outline-success {
            background-color: transparent;
            border: 1px solid var(--success);
            color: var(--success);
        }

        .btn-outline-success:hover {
            background-color: var(--success);
            color: white;
        }

        .btn-danger {
            background-color: var(--danger);
            color: white;
        }

        .btn-danger:hover {
            background-color: #c0392b;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(214, 48, 49, 0.3);
        }

        .btn-outline-danger {
            background-color: transparent;
            border: 1px solid var(--danger);
            color: var(--danger);
        }

        .btn-outline-danger:hover {
            background-color: var(--danger);
            color: white;
        }

        .btn-warning {
            background-color: var(--warning);
            color: var(--dark);
        }

        .btn-warning:hover {
            background-color: #fdc14a;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(253, 203, 110, 0.3);
        }

        .btn-outline-warning {
            background-color: transparent;
            border: 1px solid var(--warning);
            color: var(--warning);
        }

        .btn-outline-warning:hover {
            background-color: var(--warning);
            color: var(--dark);
        }

        .btn-info {
            background-color: var(--info);
            color: white;
        }

        .btn-info:hover {
            background-color: #0876c4;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(9, 132, 227, 0.3);
        }

        .btn-outline-info {
            background-color: transparent;
            border: 1px solid var(--info);
            color: var(--info);
        }

        .btn-outline-info:hover {
            background-color: var(--info);
            color: white;
        }

        .btn-secondary {
            background-color: var(--gray);
            color: white;
        }

        .btn-secondary:hover {
            background-color: #555b5e;
            transform: translateY(-2px);
            box-shadow: 0 5px 15px rgba(99, 110, 114, 0.3);
        }

        .btn-outline-secondary {
            background-color: transparent;
            border: 1px solid var(--gray);
            color: var(--gray);
        }

        .btn-outline-secondary:hover {
            background-color: var(--gray);
            color: white;
        }

        .btn-link {
            color: var(--primary);
            background-color: transparent;
            padding: 8px 10px;
        }

        .btn-link:hover {
            color: var(--primary-dark);
            text-decoration: underline;
            background-color: rgba(108, 92, 231, 0.1);
            transform: none;
            box-shadow: none;
        }

        .btn-group {
            display: inline-flex;
            align-items: center;
        }

        .btn-group .btn {
            margin-right: 5px;
        }

        .btn-group .btn:last-child {
            margin-right: 0;
        }

        /* Dropdown Toggle Button */
        .dropdown-toggle::after {
            display: inline-block;
            margin-left: 0.255em;
            vertical-align: 0.255em;
            content: "";
            border-top: 0.3em solid;
            border-right: 0.3em solid transparent;
            border-bottom: 0;
            border-left: 0.3em solid transparent;
        }

        .btn.dropdown-toggle {
            padding-right: 15px;
        }

        .btn-sm.dropdown-toggle {
            padding-right: 12px;
        }

        .btn-lg.dropdown-toggle {
            padding-right: 20px;
        }

        /* Three Dots Button */
        .btn-dots {
            background: none;
            border: none;
            color: var(--gray);
            padding: 5px 10px;
            border-radius: 50%;
            width: 30px;
            height: 30px;
            display: flex;
            align-items: center;
            justify-content: center;
            transition: all 0.3s ease;
        }

        .btn-dots:hover {
            background-color: rgba(0,0,0,0.05);
            color: var(--dark);
        }

        .btn-dots i {
            margin: 0;
        }
        
        /* Custom dropdown styles */
        .dropdown-menu {
            border: none;
            box-shadow: 0 5px 15px rgba(0,0,0,0.1);
            border-radius: 10px;
            padding: 5px 0;
            min-width: 200px;
            margin-top: 5px;
        }
        
        .dropdown-item {
            padding: 8px 20px;
            transition: all 0.3s ease;
            font-size: 0.9rem;
            display: flex;
            align-items: center;
        }
        
        .dropdown-item:hover {
            background-color: var(--light);
            color: var(--primary);
        }
        
        .dropdown-item i {
            margin-right: 10px;
            width: 20px;
            text-align: center;
            font-size: 0.9rem;
        }
        
        .dropdown-divider {
            margin: 5px 0;
            border-color: rgba(0,0,0,0.05);
        }

        /* Forms */
        .form-group {
            margin-bottom: 1.5rem;
        }

        .form-label {
            font-weight: 500;
            margin-bottom: 8px;
            color: var(--dark);
            display: block;
            font-size: 0.9rem;
        }

        .form-control {
            border: 1px solid var(--light-gray);
            border-radius: 5px;
            padding: 10px 15px;
            height: auto;
            transition: all 0.3s ease;
            width: 100%;
            font-size: 0.9rem;
        }

        .form-control:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(108, 92, 231, 0.2);
        }

        textarea.form-control {
            min-height: 100px;
            resize: vertical;
        }

        .input-group {
            display: flex;
            align-items: stretch;
            width: 100%;
        }

        .input-group-prepend {
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            margin-bottom: 0;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0.25rem 0 0 0.25rem;
            border-right: none;
        }

        .input-group-append {
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            margin-bottom: 0;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
            border-radius: 0 0.25rem 0.25rem 0;
            border-left: none;
        }

        .input-group-text {
            display: flex;
            align-items: center;
            padding: 0.375rem 0.75rem;
            margin-bottom: 0;
            font-size: 0.9rem;
            font-weight: 400;
            line-height: 1.5;
            color: #495057;
            text-align: center;
            white-space: nowrap;
            background-color: #e9ecef;
            border: 1px solid #ced4da;
        }

        .input-group > .form-control {
            position: relative;
            flex: 1 1 auto;
            width: 1%;
            margin-bottom: 0;
        }

        .input-group > .form-control:not(:first-child) {
            border-top-left-radius: 0;
            border-bottom-left-radius: 0;
        }

        .input-group > .form-control:not(:last-child) {
            border-top-right-radius: 0;
            border-bottom-right-radius: 0;
        }

        /* Question Group */
        .question-group {
            background: #f8f9fa;
            margin-bottom: 20px;
            border-radius: 8px;
            transition: all 0.3s ease;
        }

        .question-group:hover {
            box-shadow: 0 0 15px rgba(0,0,0,0.05);
        }

        .question-number {
            font-size: 1.1rem;
            font-weight: 600;
            color: var(--primary);
            margin-bottom: 15px;
            display: flex;
            align-items: center;
        }

        .question-number::before {
            content: '';
            display: inline-block;
            width: 8px;
            height: 8px;
            background-color: var(--primary);
            border-radius: 50%;
            margin-right: 10px;
        }

        /* Progress Bar */
        .progress {
            border-radius: 10px;
            height: 20px;
            background-color: #f1f1f1;
            overflow: hidden;
        }

        .progress-bar {
            border-radius: 10px;
            font-size: 0.75rem;
            display: flex;
            align-items: center;
            justify-content: center;
            background-color: var(--primary);
            height: 100%;
            transition: width 0.6s ease;
        }

        /* Rank Circle */
        .rank-circle {
            display: inline-flex;
            align-items: center;
            justify-content: center;
            width: 30px;
            height: 30px;
            border-radius: 50%;
            background-color: var(--primary);
            color: white;
            font-weight: bold;
            font-size: 0.9rem;
        }

        /* Badges */
        .badge {
            display: inline-block;
            padding: 0.35em 0.65em;
            font-size: 0.75em;
            font-weight: 700;
            line-height: 1;
            text-align: center;
            white-space: nowrap;
            vertical-align: baseline;
            border-radius: 0.25rem;
            transition: all 0.3s ease;
        }

        .badge-primary {
            background-color: var(--primary);
            color: white;
        }

        .badge-success {
            background-color: var(--success);
            color: white;
        }

        .badge-danger {
            background-color: var(--danger);
            color: white;
        }

        .badge-warning {
            background-color: var(--warning);
            color: var(--dark);
        }

        .badge-info {
            background-color: var(--info);
            color: white;
        }

        .badge-secondary {
            background-color: var(--gray);
            color: white;
        }

        .badge-pill {
            border-radius: 50px;
        }

        .badge-light {
            background-color: var(--light-gray);
            color: var(--dark);
        }

        /* List Group */
        .list-group {
            display: flex;
            flex-direction: column;
            padding-left: 0;
            margin-bottom: 0;
            border-radius: 0.5rem;
            overflow: hidden;
        }

        .list-group-item {
            position: relative;
            display: block;
            padding: 0.75rem 1.25rem;
            background-color: #fff;
            border: 1px solid rgba(0, 0, 0, 0.05);
            transition: all 0.3s ease;
        }

        .list-group-item:first-child {
            border-top-left-radius: inherit;
            border-top-right-radius: inherit;
        }

        .list-group-item:last-child {
            border-bottom-right-radius: inherit;
            border-bottom-left-radius: inherit;
        }

        .list-group-item:hover {
            z-index: 1;
            background-color: #f8f9fa;
        }

        .list-group-item.active {
            background-color: var(--primary);
            border-color: var(--primary);
            color: white;
        }

        /* Animations */
        .animate-fade-in {
            animation: fadeIn 0.5s ease-in-out;
        }

        .animate-slide-up {
            animation: slideUp 0.5s ease-in-out;
        }

        .animate-bounce-in {
            animation: bounceIn 0.5s ease-in-out;
        }

        @keyframes fadeIn {
            from { opacity: 0; }
            to { opacity: 1; }
        }

        @keyframes slideUp {
            from { 
                opacity: 0;
                transform: translateY(20px);
            }
            to { 
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes bounceIn {
            0% { 
                opacity: 0;
                transform: scale(0.8);
            }
            50% { 
                opacity: 1;
                transform: scale(1.05);
            }
            100% { 
                transform: scale(1);
            }
        }

        /* Floating Action Button */
        .fab {
            position: fixed;
            bottom: 30px;
            right: 30px;
            width: 60px;
            height: 60px;
            border-radius: 50%;
            background: var(--primary);
            color: white;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            box-shadow: 0 5px 20px rgba(108, 92, 231, 0.4);
            cursor: pointer;
            z-index: 100;
            transition: all 0.3s ease;
            animation: pulse 2s infinite;
        }

        .fab:hover {
            transform: scale(1.1);
            box-shadow: 0 8px 25px rgba(108, 92, 231, 0.5);
        }

        @keyframes pulse {
            0% {
                box-shadow: 0 0 0 0 rgba(108, 92, 231, 0.7);
            }
            70% {
                box-shadow: 0 0 0 15px rgba(108, 92, 231, 0);
            }
            100% {
                box-shadow: 0 0 0 0 rgba(108, 92, 231, 0);
            }
        }

        /* Tooltips */
        .tooltip {
            position: absolute;
            z-index: 1070;
            display: block;
            margin: 0;
            font-family: 'Poppins', sans-serif;
            font-style: normal;
            font-weight: 400;
            line-height: 1.5;
            text-align: left;
            text-align: start;
            text-decoration: none;
            text-shadow: none;
            text-transform: none;
            letter-spacing: normal;
            word-break: normal;
            word-spacing: normal;
            white-space: normal;
            line-break: auto;
            font-size: 0.8rem;
            opacity: 0;
        }

        .tooltip.show {
            opacity: 0.9;
        }

        .tooltip .arrow {
            position: absolute;
            display: block;
            width: 0.8rem;
            height: 0.4rem;
        }

        .tooltip .arrow::before {
            position: absolute;
            content: "";
            border-color: transparent;
            border-style: solid;
        }

        .bs-tooltip-top .arrow, .bs-tooltip-auto[x-placement^="top"] .arrow {
            bottom: 0;
        }

        .bs-tooltip-top .arrow::before, .bs-tooltip-auto[x-placement^="top"] .arrow::before {
            top: 0;
            border-width: 0.4rem 0.4rem 0;
            border-top-color: #000;
        }

        .tooltip-inner {
            max-width: 200px;
            padding: 0.25rem 0.5rem;
            color: #fff;
            text-align: center;
            background-color: #000;
            border-radius: 0.25rem;
        }

        /* Responsive Styles */
        @media (max-width: 992px) {
            .sidebar {
                transform: translateX(-100%);
            }
            
            .sidebar.show {
                transform: translateX(0);
            }
            
            .main-content {
                margin-left: 0;
            }
            
            .sidebar-toggle {
                display: block !important;
            }
        }

        @media (max-width: 768px) {
            .navbar-container {
                padding: 10px 15px;
                flex-wrap: wrap;
            }
            
            .search-box-container {
                order: 2;
                width: 100%;
                margin-top: 10px;
                margin-right: 0;
            }
            
            .search-box {
                max-width: 100%;
            }
            
            .user-menu-container {
                order: 1;
                margin-left: auto;
            }
            
            .sidebar-toggle {
                order: 0;
                margin-right: 15px;
            }
            
            .stats-card {
                margin-bottom: 20px;
            }
            
            .content-area {
                padding: 20px;
            }
            
            .card-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .card-title {
                margin-bottom: 10px;
            }
            
            .btn-group {
                margin-top: 10px;
            }
        }

        @media (max-width: 576px) {
            .page-header {
                flex-direction: column;
                align-items: flex-start;
            }
            
            .page-title {
                margin-bottom: 10px;
                font-size: 1.5rem;
            }
            
            .user-menu .user-name {
                display: none;
            }
            
            .user-menu .user-img {
                margin-right: 0;
            }
            
            .content-area {
                padding: 15px;
            }
            
            .form-group.row {
                flex-direction: column;
            }
            
            .form-group.row .col-form-label,
            .form-group.row .col-md-9 {
                width: 100%;
                padding-right: 0;
                padding-left: 0;
            }
            
            .input-group {
                flex-direction: column;
            }
            
            .input-group-prepend,
            .input-group-append {
                width: 100%;
                border-radius: 5px;
                margin-bottom: 5px;
            }
            
            .input-group > .form-control {
                width: 100%;
                border-radius: 5px !important;
            }
        }

        /* Custom Scrollbar */
        ::-webkit-scrollbar {
            width: 8px;
            height: 8px;
        }

        ::-webkit-scrollbar-track {
            background: #f1f1f1;
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb {
            background: var(--primary);
            border-radius: 10px;
        }

        ::-webkit-scrollbar-thumb:hover {
            background: var(--primary-dark);
        }
    </style>
</head>

<body>
    <!-- Sidebar -->
    <div class="sidebar animate-slide-up">
        <div class="sidebar-header">
            <h3 class="animate-bounce-in">QuizMaster</h3>
            <button class="toggle-btn" id="toggleSidebar">
                <i class="fas fa-chevron-left"></i>
            </button>
        </div>
        <div class="sidebar-menu">
            <ul class="nav flex-column">
                <li class="nav-item">
                    <a href="dashboard.php?q=0" class="nav-link <?php if(@$_GET['q']==0) echo 'active'; ?>">
                        <i class="fas fa-tachometer-alt"></i>
                        <span>Dashboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php?q=1" class="nav-link <?php if(@$_GET['q']==1) echo 'active'; ?>">
                        <i class="fas fa-users"></i>
                        <span>User Management</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php?q=2" class="nav-link <?php if(@$_GET['q']==2) echo 'active'; ?>">
                        <i class="fas fa-trophy"></i>
                        <span>Leaderboard</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php?q=4" class="nav-link <?php if(@$_GET['q']==4) echo 'active'; ?>">
                        <i class="fas fa-plus-circle"></i>
                        <span>Add Quiz</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="dashboard.php?q=5" class="nav-link <?php if(@$_GET['q']==5) echo 'active'; ?>">
                        <i class="fas fa-tasks"></i>
                        <span>Manage Quizzes</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a href="logout1.php?q=dashboard.php" class="nav-link">
                        <i class="fas fa-sign-out-alt"></i>
                        <span>Logout</span>
                    </a>
                </li>
            </ul>
        </div>
    </div>

    <!-- Main Content -->
    <div class="main-content">
        <!-- Top Navbar -->
        <nav class="top-navbar navbar-expand-lg">
            <div class="navbar-container">
                <button class="sidebar-toggle d-lg-none d-block" id="mobileSidebarToggle">
                    <i class="fas fa-bars"></i>
                </button>
                
                <div class="navbar-content">
                    <div class="search-box-container">
                        <div class="search-box">
                            <i class="fas fa-search"></i>
                            <input type="text" placeholder="Search...">
                        </div>
                    </div>
                    
                    <div class="user-menu-container">
                        <div class="dropdown user-menu">
                            <button class="dropdown-toggle" type="button" id="userDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <div class="user-img"><?php echo substr($name, 0, 1); ?></div>
                                <span class="user-name d-none d-md-inline"><?php echo $name; ?></span>
                                <i class="fas fa-chevron-down d-none d-md-inline"></i>
                            </button>
                            <div class="dropdown-menu dropdown-menu-right" aria-labelledby="userDropdown">
                                <a class="dropdown-item" href="#"><i class="fas fa-user"></i> Profile</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-cog"></i> Settings</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="logout1.php?q=dashboard.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </nav>

        <!-- Content Area -->
        <div class="content-area animate-fade-in">
            <?php if(@$_GET['q']==0): ?>
                <div class="page-header">
                    <h1 class="page-title">Dashboard Overview</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Dashboard</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="row">
                    <div class="col-md-3">
                        <div class="stats-card primary animate-slide-up" style="animation-delay: 0.1s;">
                            <div class="icon">
                                <i class="fas fa-users"></i>
                            </div>
                            <div class="stats-title">Total Users</div>
                            <?php 
                                $result = mysqli_query($con,"SELECT COUNT(*) as total FROM user");
                                $row = mysqli_fetch_assoc($result);
                                $total_users = $row['total'];
                            ?>
                            <div class="stats-value"><?php echo $total_users; ?></div>
                            <div class="stats-change">
                                <i class="fas fa-arrow-up"></i> 12% from last month
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card success animate-slide-up" style="animation-delay: 0.2s;">
                            <div class="icon">
                                <i class="fas fa-question-circle"></i>
                            </div>
                            <div class="stats-title">Total Quizzes</div>
                            <?php 
                                $result = mysqli_query($con,"SELECT COUNT(*) as total FROM quiz");
                                $row = mysqli_fetch_assoc($result);
                                $total_quizzes = $row['total'];
                            ?>
                            <div class="stats-value"><?php echo $total_quizzes; ?></div>
                            <div class="stats-change">
                                <i class="fas fa-arrow-up"></i> 5% from last month
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card warning animate-slide-up" style="animation-delay: 0.3s;">
                            <div class="icon">
                                <i class="fas fa-check-circle"></i>
                            </div>
                            <div class="stats-title">Completed Tests</div>
                            <?php 
                                $result = mysqli_query($con,"SELECT COUNT(*) as total FROM history");
                                $row = mysqli_fetch_assoc($result);
                                $total_tests = $row['total'];
                            ?>
                            <div class="stats-value"><?php echo $total_tests; ?></div>
                            <div class="stats-change">
                                <i class="fas fa-arrow-up"></i> 8% from last month
                            </div>
                        </div>
                    </div>
                    <div class="col-md-3">
                        <div class="stats-card danger animate-slide-up" style="animation-delay: 0.4s;">
                            <div class="icon">
                                <i class="fas fa-trophy"></i>
                            </div>
                            <div class="stats-title">Avg. Score</div>
                            <?php 
                                $result = mysqli_query($con,"SELECT AVG(score) as avg_score FROM history");
                                $row = mysqli_fetch_assoc($result);
                                $avg_score = round($row['avg_score'], 1);
                            ?>
                            <div class="stats-value"><?php echo $avg_score; ?></div>
                            <div class="stats-change">
                                <i class="fas fa-arrow-up"></i> 3% from last month
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-8">
                        <div class="card animate-slide-up" style="animation-delay: 0.5s;">
                            <div class="card-header">
                                <h5 class="card-title">Recent Activity</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-dots dropdown-toggle" type="button" id="activityDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="activityDropdown">
                                        <a class="dropdown-item" href="#"><i class="fas fa-list"></i> View All</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-filter"></i> Filter</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="fas fa-file-export"></i> Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table">
                                        <thead>
                                            <tr>
                                                <th>User</th>
                                                <th>Quiz</th>
                                                <th>Score</th>
                                                <th>Date</th>
                                                <th>Status</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php 
                                                $result = mysqli_query($con,"SELECT h.*, u.name, q.title FROM history h 
                                                JOIN user u ON h.email=u.email 
                                                JOIN quiz q ON h.eid=q.eid 
                                                ORDER BY h.date DESC LIMIT 5");
                                                while($row = mysqli_fetch_array($result)) {
                                                    $status_class = $row['score'] >= 50 ? 'success' : 'danger';
                                                    $status_text = $row['score'] >= 50 ? 'Passed' : 'Failed';
                                            ?>
                                            <tr>
                                                <td><?php echo $row['name']; ?></td>
                                                <td><?php echo $row['title']; ?></td>
                                                <td><?php echo $row['score']; ?></td>
                                                <td><?php echo date('M d, Y', strtotime($row['date'])); ?></td>
                                                <td><span class="badge badge-<?php echo $status_class; ?>"><?php echo $status_text; ?></span></td>
                                            </tr>
                                            <?php } ?>
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4">
                        <div class="card animate-slide-up" style="animation-delay: 0.6s;">
                            <div class="card-header">
                                <h5 class="card-title">Top Performers</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-dots dropdown-toggle" type="button" id="topPerformerDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-ellipsis-v"></i>
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="topPerformerDropdown">
                                        <a class="dropdown-item" href="#"><i class="fas fa-list"></i> View All</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-filter"></i> Filter</a>
                                        <div class="dropdown-divider"></div>
                                        <a class="dropdown-item" href="#"><i class="fas fa-file-export"></i> Export</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <div class="list-group">
                                    <?php 
                                        $result = mysqli_query($con,"SELECT r.*, u.name FROM rank r 
                                        JOIN user u ON r.email=u.email 
                                        ORDER BY r.score DESC LIMIT 5");
                                        $rank = 1;
                                        while($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <div class="list-group-item d-flex align-items-center">
                                        <div class="mr-3 font-weight-bold text-primary"><?php echo $rank++; ?>.</div>
                                        <div class="flex-grow-1">
                                            <div class="d-flex justify-content-between">
                                                <span class="font-weight-bold"><?php echo $row['name']; ?></span>
                                                <span class="badge badge-primary"><?php echo $row['score']; ?> pts</span>
                                            </div>
                                            <small class="text-muted"><?php echo $row['email']; ?></small>
                                        </div>
                                    </div>
                                    <?php } ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                
                <div class="row mt-4">
                    <div class="col-md-12">
                        <div class="card animate-slide-up" style="animation-delay: 0.7s;">
                            <div class="card-header">
                                <h5 class="card-title">Quiz Performance</h5>
                                <div class="dropdown">
                                    <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="chartDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                        <i class="fas fa-calendar"></i> Last 30 Days
                                    </button>
                                    <div class="dropdown-menu dropdown-menu-right" aria-labelledby="chartDropdown">
                                        <a class="dropdown-item" href="#"><i class="fas fa-calendar-week"></i> Last 7 Days</a>
                                        <a class="dropdown-item active" href="#"><i class="fas fa-calendar-alt"></i> Last 30 Days</a>
                                        <a class="dropdown-item" href="#"><i class="fas fa-calendar-day"></i> Last 90 Days</a>
                                    </div>
                                </div>
                            </div>
                            <div class="card-body">
                                <canvas id="performanceChart" height="100"></canvas>
                            </div>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(@$_GET['q']==1): ?>
                <div class="page-header">
                    <h1 class="page-title">User Management</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Users</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="card animate-slide-up">
                    <div class="card-header">
                        <h5 class="card-title">All Users</h5>
                        <div class="d-flex">
                            <div class="dropdown mr-2">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="filterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <div class="dropdown-menu" aria-labelledby="filterDropdown">
                                    <a class="dropdown-item" href="#"><i class="fas fa-check-circle"></i> Active</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-times-circle"></i> Inactive</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#"><i class="fas fa-sync-alt"></i> Reset</a>
                                </div>
                            </div>
                            <button class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Add User
                            </button>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>College</th>
                                        <th>Joined</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $result = mysqli_query($con,"SELECT * FROM user");
                                        $c = 1;
                                        while($row = mysqli_fetch_array($result)) {
                                    ?>
                                    <tr>
                                        <td><?php echo $c++; ?></td>
                                        <td><?php echo $row['name']; ?></td>
                                        <td><?php echo $row['email']; ?></td>
                                        <td><?php echo $row['college']; ?></td>
                                        <td><?php echo date('M d, Y', strtotime($row['time'])); ?></td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="update.php?demail=<?php echo $row['email']; ?>" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(@$_GET['q']==2): ?>
                <div class="page-header">
                    <h1 class="page-title">Leaderboard</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Leaderboard</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="card animate-slide-up">
                    <div class="card-header">
                        <h5 class="card-title">Top Performers</h5>
                        <div class="dropdown">
                            <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="leaderboardDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <i class="fas fa-download"></i> Export
                            </button>
                            <div class="dropdown-menu" aria-labelledby="leaderboardDropdown">
                                <a class="dropdown-item" href="#"><i class="fas fa-file-csv"></i> CSV</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-file-excel"></i> Excel</a>
                                <a class="dropdown-item" href="#"><i class="fas fa-file-pdf"></i> PDF</a>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>Rank</th>
                                        <th>Name</th>
                                        <th>Email</th>
                                        <th>Score</th>
                                        <th>Badges</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $q=mysqli_query($con,"SELECT * FROM rank ORDER BY score DESC");
                                        $c=1;
                                        while($row=mysqli_fetch_array($q)) {
                                            $e=$row['email'];
                                            $s=$row['score'];
                                            $q12=mysqli_query($con,"SELECT * FROM user WHERE email='$e'");
                                            while($row2=mysqli_fetch_array($q12)) {
                                                $name=$row2['name'];
                                                $college=$row2['college'];
                                            }
                                    ?>
                                    <tr>
                                        <td>
                                            <div class="rank-circle"><?php echo $c; ?></div>
                                        </td>
                                        <td><?php echo $name; ?></td>
                                        <td><?php echo $e; ?></td>
                                        <td>
                                            <div class="progress" style="height: 20px;">
                                                <div class="progress-bar bg-primary" role="progressbar" style="width: <?php echo min($s, 100); ?>%" aria-valuenow="<?php echo $s; ?>" aria-valuemin="0" aria-valuemax="100">
                                                    <?php echo $s; ?> pts
                                                </div>
                                            </div>
                                        </td>
                                        <td>
                                            <?php if($c == 1): ?>
                                                <span class="badge badge-warning"><i class="fas fa-crown"></i> Gold</span>
                                            <?php elseif($c == 2): ?>
                                                <span class="badge badge-secondary"><i class="fas fa-medal"></i> Silver</span>
                                            <?php elseif($c == 3): ?>
                                                <span class="badge badge-danger"><i class="fas fa-medal"></i> Bronze</span>
                                            <?php elseif($s >= 80): ?>
                                                <span class="badge badge-success"><i class="fas fa-star"></i> Expert</span>
                                            <?php elseif($s >= 50): ?>
                                                <span class="badge badge-info"><i class="fas fa-award"></i> Advanced</span>
                                            <?php endif; ?>
                                        </td>
                                    </tr>
                                    <?php 
                                        $c++;
                                        } 
                                    ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(@$_GET['q']==4 && !(@$_GET['step'])): ?>
                <div class="page-header">
                    <h1 class="page-title">Create New Quiz</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Quizzes</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Add Quiz</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="card animate-slide-up">
                    <div class="card-header">
                        <h5 class="card-title">Quiz Details</h5>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" name="form" action="update.php?q=addquiz" method="POST">
                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="name">Quiz Title</label>
                                <div class="col-md-9">
                                    <input id="name" name="name" placeholder="Enter Quiz title" class="form-control" type="text" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="total">Total Questions</label>
                                <div class="col-md-9">
                                    <input id="total" name="total" placeholder="Enter total number of questions" class="form-control" type="number" min="1" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="right">Marks per Correct Answer</label>
                                <div class="col-md-9">
                                    <input id="right" name="right" placeholder="Enter marks for correct answer" class="form-control" min="1" type="number" required>
                                </div>
                            </div>

                            <div class="form-group row">
                                <label class="col-md-3 col-form-label" for="wrong">Negative Marks</label>
                                <div class="col-md-9">
                                    <input id="wrong" name="wrong" placeholder="Enter minus marks for wrong answer" class="form-control" min="0" type="number" required>
                                </div>
                            </div>
                            
                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-primary btn-lg">
                                        <i class="fas fa-save"></i> Create Quiz
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(@$_GET['q']==4 && (@$_GET['step'])==2): ?>
                <div class="page-header">
                    <h1 class="page-title">Add Questions</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item"><a href="#">Quizzes</a></li>
                            <li class="breadcrumb-item"><a href="#">Add Quiz</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Questions</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="card animate-slide-up">
                    <div class="card-header">
                        <h5 class="card-title">Add Questions to Quiz</h5>
                    </div>
                    <div class="card-body">
                        <form class="form-horizontal" name="form" action="update.php?q=addqns&n=<?php echo @$_GET['n']; ?>&eid=<?php echo @$_GET['eid']; ?>&ch=4" method="POST">
                            <?php for($i=1;$i<=@$_GET['n'];$i++): ?>
                            <div class="question-group mb-4 p-3 border rounded">
                                <h5 class="question-number mb-3 text-primary">Question <?php echo $i; ?></h5>
                                
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="qns<?php echo $i; ?>">Question Text</label>
                                    <div class="col-md-10">
                                        <textarea rows="3" name="qns<?php echo $i; ?>" class="form-control" placeholder="Write question number <?php echo $i; ?> here..." required></textarea>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label">Options</label>
                                    <div class="col-md-10">
                                        <div class="row">
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">A</span>
                                                    </div>
                                                    <input name="<?php echo $i; ?>1" placeholder="Enter option a" class="form-control" type="text" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">B</span>
                                                    </div>
                                                    <input name="<?php echo $i; ?>2" placeholder="Enter option b" class="form-control" type="text" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">C</span>
                                                    </div>
                                                    <input name="<?php echo $i; ?>3" placeholder="Enter option c" class="form-control" type="text" required>
                                                </div>
                                            </div>
                                            <div class="col-md-6 mb-2">
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <span class="input-group-text">D</span>
                                                    </div>
                                                    <input name="<?php echo $i; ?>4" placeholder="Enter option d" class="form-control" type="text" required>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                
                                <div class="form-group row">
                                    <label class="col-md-2 col-form-label" for="ans<?php echo $i; ?>">Correct Answer</label>
                                    <div class="col-md-10">
                                        <select name="ans<?php echo $i; ?>" class="form-control" required>
                                            <option value="">Select correct answer</option>
                                            <option value="a">Option A</option>
                                            <option value="b">Option B</option>
                                            <option value="c">Option C</option>
                                            <option value="d">Option D</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <?php endfor; ?>
                            
                            <div class="form-group row">
                                <div class="col-md-12 text-center">
                                    <button type="submit" class="btn btn-success btn-lg">
                                        <i class="fas fa-check-circle"></i> Submit All Questions
                                    </button>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            <?php endif; ?>
            
            <?php if(@$_GET['q']==5): ?>
                <div class="page-header">
                    <h1 class="page-title">Manage Quizzes</h1>
                    <nav aria-label="breadcrumb">
                        <ol class="breadcrumb">
                            <li class="breadcrumb-item"><a href="#">Home</a></li>
                            <li class="breadcrumb-item active" aria-current="page">Manage Quizzes</li>
                        </ol>
                    </nav>
                </div>
                
                <div class="card animate-slide-up">
                    <div class="card-header">
                        <h5 class="card-title">All Quizzes</h5>
                        <div class="d-flex">
                            <div class="dropdown mr-2">
                                <button class="btn btn-sm btn-outline-primary dropdown-toggle" type="button" id="quizFilterDropdown" data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                    <i class="fas fa-filter"></i> Filter
                                </button>
                                <div class="dropdown-menu" aria-labelledby="quizFilterDropdown">
                                    <a class="dropdown-item" href="#"><i class="fas fa-check-circle"></i> Active</a>
                                    <a class="dropdown-item" href="#"><i class="fas fa-times-circle"></i> Inactive</a>
                                    <div class="dropdown-divider"></div>
                                    <a class="dropdown-item" href="#"><i class="fas fa-sync-alt"></i> Reset</a>
                                </div>
                            </div>
                            <a href="dashboard.php?q=4" class="btn btn-sm btn-primary">
                                <i class="fas fa-plus"></i> Add Quiz
                            </a>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table">
                                <thead>
                                    <tr>
                                        <th>ID</th>
                                        <th>Title</th>
                                        <th>Questions</th>
                                        <th>Marks</th>
                                        <th>Created</th>
                                        <th>Status</th>
                                        <th>Actions</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php 
                                        $result = mysqli_query($con,"SELECT * FROM quiz ORDER BY date DESC");
                                        $c=1;
                                        while($row = mysqli_fetch_array($result)) {
                                            $title = $row['title'];
                                            $total = $row['total'];
                                            $sahi = $row['sahi'];
                                            $eid = $row['eid'];
                                            $date = date('M d, Y', strtotime($row['date']));
                                    ?>
                                    <tr>
                                        <td><?php echo $c++; ?></td>
                                        <td><?php echo $title; ?></td>
                                        <td><?php echo $total; ?></td>
                                        <td><?php echo $sahi*$total; ?></td>
                                        <td><?php echo $date; ?></td>
                                        <td>
                                            <span class="badge badge-success">Active</span>
                                        </td>
                                        <td>
                                            <div class="btn-group">
                                                <button class="btn btn-sm btn-outline-primary" data-toggle="tooltip" title="Edit">
                                                    <i class="fas fa-edit"></i>
                                                </button>
                                                <a href="update.php?q=rmquiz&eid=<?php echo $eid; ?>" class="btn btn-sm btn-outline-danger" data-toggle="tooltip" title="Delete">
                                                    <i class="fas fa-trash"></i>
                                                </a>
                                                <button class="btn btn-sm btn-outline-info" data-toggle="tooltip" title="View">
                                                    <i class="fas fa-eye"></i>
                                                </button>
                                            </div>
                                        </td>
                                    </tr>
                                    <?php } ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>
    
    <!-- Floating Action Button -->
    <div class="fab animate-bounce-in">
        <i class="fas fa-question"></i>
    </div>
    
    <!-- Scripts -->
    <script src="https://cdn.jsdelivr.net/npm/popper.js@1.16.0/dist/umd/popper.min.js"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.4.1/js/bootstrap.min.js"></script>
    
    <script>
        // Toggle sidebar
        $('#toggleSidebar').click(function(){
            $('.sidebar').toggleClass('collapsed');
            $('.main-content').toggleClass('collapsed');
            
            // Change icon
            if($('.sidebar').hasClass('collapsed')) {
                $(this).html('<i class="fas fa-chevron-right"></i>');
            } else {
                $(this).html('<i class="fas fa-chevron-left"></i>');
            }
        });
        
        // Mobile sidebar toggle
        $('#mobileSidebarToggle').click(function(){
            $('.sidebar').toggleClass('show');
        });
        
        // Initialize tooltips
        $(function () {
            $('[data-toggle="tooltip"]').tooltip()
        });
        
        // Make navbar sticky and add shadow on scroll
        $(window).scroll(function() {
            if ($(window).scrollTop() > 10) {
                $('.top-navbar').addClass('scrolled');
            } else {
                $('.top-navbar').removeClass('scrolled');
            }
        });
        
        // Performance chart
        var ctx = document.getElementById('performanceChart').getContext('2d');
        var performanceChart = new Chart(ctx, {
            type: 'line',
            data: {
                labels: ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul'],
                datasets: [{
                    label: 'Quiz Attempts',
                    data: [12, 19, 15, 27, 22, 31, 25],
                    backgroundColor: 'rgba(108, 92, 231, 0.1)',
                    borderColor: 'rgba(108, 92, 231, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }, {
                    label: 'Average Score',
                    data: [65, 59, 70, 72, 68, 75, 80],
                    backgroundColor: 'rgba(253, 121, 168, 0.1)',
                    borderColor: 'rgba(253, 121, 168, 1)',
                    borderWidth: 2,
                    tension: 0.4,
                    fill: true
                }]
            },
            options: {
                responsive: true,
                plugins: {
                    legend: {
                        position: 'top',
                    },
                    tooltip: {
                        mode: 'index',
                        intersect: false,
                    }
                },
                scales: {
                    y: {
                        beginAtZero: true,
                        max: 100
                    }
                }
            }
        });
        
        // Animate elements when they come into view
        $(document).ready(function() {
            $(window).scroll(function() {
                $('.animate-on-scroll').each(function() {
                    var position = $(this).offset().top;
                    var scroll = $(window).scrollTop();
                    var windowHeight = $(window).height();
                    
                    if (scroll + windowHeight > position) {
                        $(this).addClass('animated');
                    }
                });
            });
        });
        
        // Fab button click
        $('.fab').click(function() {
            alert('Need help? Contact our support team at support@quizmaster.com');
        });
    </script>
</body>
</html>