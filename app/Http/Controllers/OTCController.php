<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\OtcPlayers;
use App\OtcNewMatches;
use Illuminate\Support\Facades\DB;

class OTCController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        Self::updateLocalDb();

        $new_matches = DB::table('otc_new_matches')->orderByDesc('created_at')->take(500)->get();
        return view('otc.index')->withMatches($new_matches);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        Self::updateLocalDb();
        $new_matches = DB::table('otc_new_matches')->orderByDesc('created_at')->take(500)->get();
        return $new_matches;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    /**
     * @return this $this
     */
    private function updateLocalDb() {
        $jsonurl = "https://offworldtc-api-tachyon.stardock.net/v1/products/2618/leaderboards/ladder/0b006c2d-959a-4460-899f-5211741b0976?offset=0&count=100&teamId=&includeMatchData=false";
        $json_1v1 = json_decode(file_get_contents($jsonurl), true);
        $jsonurl = "https://offworldtc-api-tachyon.stardock.net/v1/products/2618/leaderboards/ladder/b855cc1e-b1c2-45bd-936f-f9d39de49f58?offset=0&count=100&teamId=&includeMatchData=false";
        $json_ffa = json_decode(file_get_contents($jsonurl), true);
        
        if ( ! is_array($json_1v1)) {
            debug ('$json_1v1 is not array');
            return view ('otc.index');
        }
        
        $count = [0, 0, 0];
        foreach ($json_1v1 as $json_player) {
            $local_player = OtcPlayers::where('db_id', $json_player['personaId'])->first();

            if ($local_player === null) {

                $count[0]++;
                $OtcPlayer                = new OtcPlayers;
                $OtcPlayer->name          = $json_player['personaName'];
                $OtcPlayer->db_id         = $json_player['personaId'];
                $OtcPlayer->total_matches = $json_player['totalMatchesPlayed'];
                $OtcPlayer->rank          = $json_player['rank'];
                $OtcPlayer->save();

            } else {

                $count[1]++;
                $name = $json_player['personaName'];

                # if this becomes true then some point of data about the player data changed and needs to be updated
                $changed = false;

                if ($local_player->rank           !== $json_player['rank']) {
                    $local_player->rank           =   $json_player['rank'];
                    $changed = true;
                }

                if ($local_player->total_matches  !== $json_player['totalMatchesPlayed']) {
                    $local_player->total_matches  =   $json_player['totalMatchesPlayed'];
                    $changed = true;

                    $new_match = new OtcNewMatches;
                    $new_match->player_name = $json_player['personaName'];
                    $new_match->rank        = $json_player['rank'];
                    $new_match->type    = '1v1';
                    $new_match->save();
                }

                if ($changed) {
                    $local_player->save();
                }
            }
        }

        foreach ($json_ffa as $json_player) {
            $local_player = OtcPlayers::where('db_id', $json_player['personaId'])->first();

            if ($local_player === null) {

                $count[0]++;
                $OtcPlayer                      = new OtcPlayers;
                $OtcPlayer->name                = $json_player['personaName'];
                $OtcPlayer->db_id               = $json_player['personaId'];
                $OtcPlayer->total_matches_ffa   = $json_player['totalMatchesPlayed'];
                $OtcPlayer->rank_ffa            = $json_player['rank'];
                $OtcPlayer->save();

            } else {

                $count[1]++;
                $name = $json_player['personaName'];

                # if this becomes true then some point of data about the player data changed and needs to be updated
                $changed = false;

                if ($local_player->total_matches_ffa  !== $json_player['totalMatchesPlayed']) {
                    debug('b');

                    $count[2]++;

                    $local_player->total_matches_ffa  =   $json_player['totalMatchesPlayed'];
                    $changed = true;

                    $new_match = new OtcNewMatches;
                    $new_match->player_name = $json_player['personaName'];
                    $new_match->rank    = $json_player['rank'];
                    $new_match->type    = 'FFA';
                    $new_match->save();
                }

                if ($local_player->rank_ffa           !== $json_player['rank'] || 
                    $local_player->rank_ffa           ==  999) {
                        $local_player->rank_ffa           =   $json_player['rank'];
                        $local_player->total_matches_ffa  =   $json_player['totalMatchesPlayed'];
                        $changed = true;
                        debug('a');
                }

                if ($changed) {
                    $local_player->save();
                }
            }
        }
        debug($count);
        return $this;
    }
}
