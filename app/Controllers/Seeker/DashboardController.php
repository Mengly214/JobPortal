<?php
class Seeker_DashboardController extends Controller {
    public function index(): void {
        requireAuth();
        $this->view('seeker/dashboard', ['pageTitle' => 'My Dashboard', 'activePage' => '']);
    }
}
hsdhdhdhdhd
hello world