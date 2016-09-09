<?php

class ProfileView
{
    static function getChamberHyperlink($map, $mapInfo) {
        if (array_key_exists($map, $mapInfo["maps"])) {
            return "<a href=/chamber/" . $map . ">" . $mapInfo["maps"][$map]["mapName"] . "</a>";
        }
        else {
            return $map;
        }
    }
    static function getChapterHyperlink($chapter, $mapInfo) {
        if (array_key_exists($chapter, $mapInfo["chapters"])) {
            return "<a href=/aggregated/chapter/" . $chapter . ">" . $mapInfo["chapters"][$chapter]["chapterName"] . "</a>";
        }
        else {
            return $chapter;
        }
    }
    static function pointTimeScoreRow($score, $title, $isTimeData) {?>
        <div class="scoreTableEntry">
            <div class="row">
                <div class="cell title"><?=$title;?></div>
                <div class="cell rank" align="right"><?=isset($score["playerRank"]) ? $score["playerRank"] : "-"?></div>
                <div class="cell score" align="right"><?=isset($score["score"]) ? ($isTimeData ? Leaderboard::convertToTime($score["score"]) : $score["score"]) : "-"?></div>
                <div class="cell nr-diff" align="right"><?=(isset($score["nextRankDiff"])) ? ($score["WRDiff"] != NULL ? ($isTimeData ? "+".Leaderboard::convertToTime($score["nextRankDiff"]) : "-".$score["nextRankDiff"]) : "-") : "-"?></div>
                <div class="cell wr-diff" align="right"><?=(isset($score["WRDiff"])) ? ($score["WRDiff"] != NULL ? ($isTimeData ? "+".Leaderboard::convertToTime($score["WRDiff"])  : "-".$score["WRDiff"]) : "-") : "-"?></div>
            </div>
        </div>
    <?php }

    static function chamberScoreRow($user, $mapInfo, $map, $score) { ?>
        <div class="scoreTableEntry">
            <div class="row chamberScoreInfo" date="<?=$score["date"]?>">
                <div class="cell scoreMenuToggle" onclick="openScoreMenu(event, '<?=$map?>', '<?=$score["changelogId"]?>')">
                    <i class="fa fa-xs fa-caret-right" aria-hidden="true"></i>
                </div>
                <div class="cell dateDifferenceColor" date="<?=$score["date"]?>"></div>
                <div class="cell title"><?=self::getChamberHyperlink($map, $mapInfo);?></div>
                <div class="cell demo-url" align="center">
                    <a href="/getDemo?id=<?=$score["changelogId"]?>" <?php if ($score["hasDemo"] == 0): ?> style="display:none" <?php endif; ?>>
                        <i class="fa fa-download" aria-hidden="true"></i>
                    </a>
                </div>
                <div class="cell youtube" align="center">
                    <i <?php if ($score["youtubeID"] == NULL): ?>
                        style="display:none"
                    <?php else : ?>
                        onclick="embedOnBody('<?=$score["youtubeID"]?>', '<?=$mapInfo["maps"][$map]["mapName"]?> - #<?=$score["playerRank"]?> - <?=Leaderboard::convertToTime($score["score"])?>');"
                    <?php endif; ?>
                    class="youtubeEmbedButton fa fa-youtube-play" aria-hidden="true"></i>
                </div>
                <div class="cell rank" align="right"><?=isset($score["playerRank"]) ? $score["playerRank"] : "-"?></div>
                <a class="cell score" align="right" href="/changelog?profileNumber=<?=$user->profileNumber?>&chamber=<?=$map?>">
                    <?=isset($score["score"]) ? Leaderboard::convertToTime($score["score"])  : "-"?>
                </a>
                <div class="cell nr-diff" align="right"><?=(isset($score["nextRankDiff"])) ? ($score["WRDiff"] != NULL ? "+".Leaderboard::convertToTime($score["nextRankDiff"]) : "-".$score["nextRankDiff"]) : "-"?></div>
                <div class="cell wr-diff" align="right"><?=(isset($score["WRDiff"])) ? ($score["WRDiff"] != NULL ? "+".Leaderboard::convertToTime($score["WRDiff"])  : "-".$score["WRDiff"]) : "-"?></div>
            </div>
            <div class="row scoreMenu"></div>
        </div>
    <?php }

    static function emptyChamberScoreRow($map, $mapInfo) { ?>
        <div class="scoreTableEntry">
            <div class="row chamberScoreInfo">
                <div class="cell scoreMenuToggle" onclick="openScoreMenu(event, '<?=$map?>')">
                    <i class="fa fa-xs fa-caret-right" aria-hidden="true"></i>
                </div>
                <div class="cell dateDifferenceColor"></div>
                <div class="cell title" align="left"><?=self::getChamberHyperlink($map, $mapInfo);?></div>
                <div class="cell demo-url"></div>
                <div class="cell youtube">
                </div>
                <div class="cell rank" align="right">-</div>
                <div class="cell score" align="right">-</div>
                <div class="cell nr-diff" align="right">-</div>
                <div class="cell wr-diff" align="right">-</div>
            </div>
            <div class="row scoreMenu"></div>
        </div>
    <?php }
}