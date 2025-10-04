<?php
defined('PREVENT_DIRECT_ACCESS') OR exit('No direct script access allowed');

/**
 * Model: HighscoreModel
 * 
 * Automatically generated via CLI.
 */
class HighscoreModel extends Model {
    protected $table = 'highscores';
    protected $primary_key = 'id';

    public function __construct()
    {
        parent::__construct();
    }

    public function save_score($player_id, $score, $board_size)
    {
        $data = [
            'user_id'  => $player_id,
            'score'      => $score,
            'board_size' => $board_size
        ];

        return $this->db->table($this->table)->insert($data);
    }

    /**
     * Global leaderboard with pagination
     */
    public function page_scores($records_per_page = null, $page = null, $board_size = null)
    {
        $query = $this->db->table($this->table . ' h')
                          ->select('h.score, h.board_size, h.created_at, u.username AS username')
                          ->join('users u', 'u.id = h.user_id')
                          ->order_by('h.score', 'DESC');

        if (!empty($board_size)) {
            $query->where('h.board_size', $board_size);
        }

        // Clone for total count
        $countQuery = clone $query;
        $data['total_rows'] = $countQuery->select_count('*', 'count')
                                         ->get()['count'];

        // Paginated records
        $data['records'] = $query->pagination($records_per_page, $page)
                                 ->get_all();

        return $data;
    }

    /**
     * Player-specific scores with pagination
     */
    public function page_player_scores($player_id, $records_per_page = null, $page = null, $board_size = null)
    {
        $query = $this->db->table($this->table . ' h')
                          ->select('h.score, h.board_size, h.created_at')
                          ->where('h.user_id', $player_id)
                          ->order_by('h.score', 'DESC');

        if (!empty($board_size)) {
            $query->where('h.board_size', $board_size);
        }

        // Clone for total count
        $countQuery = clone $query;
        $data['total_rows'] = $countQuery->select_count('*', 'count')
                                         ->get()['count'];

        // Paginated records
        $data['records'] = $query->pagination($records_per_page, $page)
                                 ->get_all();

        return $data;
    }

    public function get_distinct_board_sizes()
    {
        return $this->db
            ->table($this->table)
            ->select('board_size')
            ->group_by('board_size')
            ->order_by('board_size', 'ASC')
            ->get_all();
    }



}