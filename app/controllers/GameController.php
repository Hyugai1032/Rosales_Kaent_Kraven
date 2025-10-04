<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Controller: GameController
 * 
 * Automatically generated via CLI.
 */
class GameController extends Controller {
    public function __construct()
    {
        parent::__construct();
        $this->call->model('HighscoreModel');
        $this->call->library('auth');
        $this->call->library('session');
    }

    public function snake()
    {

        if (!$this->auth->is_logged_in()) {
            redirect('auth/login');
        }

        if ($this->io->method() === 'post') {
            // Handle form submission
            $Pace = $this->io->post('SnakePace');
            if ($Pace === "Slow") {
                $SnakePace = 300;
            } elseif ($Pace === "Medium") {
                $SnakePace = 250;
            } elseif ($Pace === "Fast") {
                $SnakePace = 200;
            } else {
                $SnakePace = 250; // default fallback
            }

            $BoardSize  = $this->io->post('BoardSize');
            $BoardSizex = substr($BoardSize, 0, 3);
            $BoardSizey = substr($BoardSize, 6, 3);
            $Goals      = (int) $this->io->post('Goals');

            // Save into session
            $settings = [
                'SnakePace'  => $SnakePace,
                'BoardSizex' => (int) $BoardSizex,
                'BoardSizey' => (int) $BoardSizey,
                'Goals'      => $Goals,
            ];

            $this->session->set_userdata('gameSettings', $settings);

            // Start the game view with chosen settings
            $this->call->view('snakeGame/Snake', ['gameState' => $settings]);

            return;
        }

        // If GET: check if session already has settings
        $saved = $this->session->userdata('gameSettings');

        $defaults = $saved ?? [
            'SnakePace'  => 250,
            'BoardSizex' => 300,
            'BoardSizey' => 400,
            'Goals'      => 1
        ];

        $this->call->view('snakeGame/index', ['defaults' => $defaults]);
    }


    public function save_score()
    {

        $input = json_decode(file_get_contents("php://input"), true);

        $player_id  = $this->session->userdata('user_id');
        $score      = $input['score'] ?? null;
        $board_size = $input['board_size'] ?? null;

        if (!$player_id || !$score || !$board_size) {
            echo json_encode(['status' => 'invalid data']);
            return;
        }

        $this->HighscoreModel->save_score($player_id, $score, $board_size);

        echo json_encode(['status' => 'ok', 'saved_score' => $score]);
    }

    public function highscores()
    {
        $this->call->model('HighscoreModel');

        // current page (defaults to 1)
        $current_page = 1;
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $current_page = (int) $this->io->get('page');
        }

        $records_per_page = 10;

        $board_size = '';
        if (isset($_GET['board_size']) && !empty($_GET['board_size'])) {
            $board_size = $this->io->get('board_size');
        }

        // Model returns ['records' => [...], 'total_rows' => N]
        $result = $this->HighscoreModel->page_scores($records_per_page, $current_page, $board_size ?: null);
        $scores = $result['records'];
        $total_rows = $result['total_rows'];

        $board_sizes = $this->HighscoreModel->get_distinct_board_sizes();

        // pagination setup
        $this->pagination->set_options([
            'first_link'     => '<< First',
            'last_link'      => 'Last >>',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]);
        $this->pagination->set_theme('custom');

        // Custom classes for dark mode pagination
        $this->pagination->set_custom_classes([
            'ul' => 'flex space-x-2 justify-center mt-6', // flexbox, spacing, centered
            'li' => '', // li doesn’t need much styling, spacing handled by ul
            'a'  => 'px-3 py-1 rounded-md bg-gray-800 text-gray-200 hover:bg-gray-700 transition-colors duration-150',
            'active' => 'px-3 py-1 rounded-md bg-indigo-600 text-white font-semibold',
            'disabled' => 'px-3 py-1 rounded-md bg-gray-900 text-gray-500 cursor-not-allowed',
        ]);

        $base_url = site_url('leaderboard') . '?board_size=' . urlencode($board_size);
        $this->pagination->initialize($total_rows, $records_per_page, $current_page, $base_url);

        $page_links = $this->pagination->paginate();

        $start_rank = max(0, ($current_page - 1) * $records_per_page);

        $this->call->view('snakeGame/leaderboard', [
            'scores' => $scores,
            'board_size' => $board_size,
            'board_sizes' => $board_sizes,
            'page_links' => $page_links,          // pagination HTML
            'current_page' => $current_page,
            'records_per_page' => $records_per_page,
            'start_rank' => $start_rank,          // zero-based offset
        ]);
    }



    public function my_scores()
    {
        $this->call->model('HighscoreModel');
        $player_id = $this->session->userdata('user_id'); // or however you fetch it

        $current_page = 1;
        if (isset($_GET['page']) && !empty($_GET['page'])) {
            $current_page = (int) $this->io->get('page');
        }
        $records_per_page = 10;

        $board_size = '';
        if (isset($_GET['board_size']) && !empty($_GET['board_size'])) {
            $board_size = $this->io->get('board_size');
        }

        $result = $this->HighscoreModel->page_player_scores($player_id, $records_per_page, $current_page, $board_size ?: null);
        $scores = $result['records'];
        $total_rows = $result['total_rows'];

        $board_sizes = $this->HighscoreModel->get_distinct_board_sizes();

        $this->pagination->set_options([
            'first_link'     => '<< First',
            'last_link'      => 'Last >>',
            'next_link'      => 'Next →',
            'prev_link'      => '← Prev',
            'page_delimiter' => '&page='
        ]); 
        $this->pagination->set_theme('custom');

        // Custom classes for dark mode pagination
        $this->pagination->set_custom_classes([
            'ul' => 'flex space-x-2 justify-center mt-6', // flexbox, spacing, centered
            'li' => '', // li doesn’t need much styling, spacing handled by ul
            'a'  => 'px-3 py-1 rounded-md bg-gray-800 text-gray-200 hover:bg-gray-700 transition-colors duration-150',
            'active' => 'px-3 py-1 rounded-md bg-indigo-600 text-white font-semibold',
            'disabled' => 'px-3 py-1 rounded-md bg-gray-900 text-gray-500 cursor-not-allowed',
        ]);
        $base_url = site_url('my-scores') . '?board_size=' . urlencode($board_size);
        $this->pagination->initialize($total_rows, $records_per_page, $current_page, $base_url);

        $page_links = $this->pagination->paginate();
        $start_rank = max(0, ($current_page - 1) * $records_per_page);

        $this->call->view('snakeGame/my-scores', [
            'scores' => $scores,
            'board_size' => $board_size,
            'board_sizes' => $board_sizes,
            'page_links' => $page_links,
            'current_page' => $current_page,
            'records_per_page' => $records_per_page,
            'start_rank' => $start_rank,
        ]);
    }



}