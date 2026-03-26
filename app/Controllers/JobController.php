<?php
require_once BASE_PATH . '/app/Models/Job.php';

class JobController extends Controller {

    public function index(): void
    {
        $model     = new Job();
        $keyword   = clean($_GET['keyword']   ?? '');
        $location  = clean($_GET['location']  ?? '');
        $category  = (int)($_GET['category']  ?? 0);
        $job_type  = clean($_GET['job_type']  ?? '');
        $work_mode = clean($_GET['work_mode'] ?? '');
        $perPage   = 9;
        $page      = max(1, (int)($_GET['page'] ?? 1));
        $offset    = ($page - 1) * $perPage;

        // Make sure your Job model has this search() method!
        $result     = $model->search($keyword, $location, $category, $job_type, $work_mode, $perPage, $offset);
        $totalPages = (int)ceil($result['total'] / $perPage);

        $this->view('jobs/listing', [
            'pageTitle'   => 'Browse Jobs',
            'activePage'  => 'jobs',
            'jobs'        => $result['jobs'],
            'totalRows'   => $result['total'],
            'totalPages'  => $totalPages,
            'currentPage' => $page,
            'categories'  => $model->getCategories(), // Make sure your Job model has this method!
            'keyword'     => $keyword,
            'location'    => $location,
            'category'    => $category,
            'job_type'    => $job_type,
            'work_mode'   => $work_mode,
        ]);
    }
    public function show(string $id): void {
        $model = new Job();
        $job   = $model->find((int)$id);
        if (!$job) { $this->redirect('jobs'); return; }
        $model->incrementViews((int)$id);

        $this->view('jobs/detail', [
            'pageTitle'  => clean($job['title']),
            'activePage' => 'jobs',
            'job'        => $job,
            'skills'     => $model->getSkills((int)$id),
            'appSuccess' => '',
            'appError'   => '',
        ]);
    }
}
