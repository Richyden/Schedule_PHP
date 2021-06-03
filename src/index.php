<!DOCTYPE html>
<html>
    <head>
        <meta charset="UTF-8">
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.0.1/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-+0n0xVW2eSR5OomGNYDnhzAbDsOXxcvSN1TPprVMTNDbiYZCxYbOOl7+AMvyTG2x" crossorigin="anonymous">
        <link rel="stylesheet" href="./CSS/calendar.css">
    </head>

    <body>
        <nav class="navbar navbar-dark bg-primary mb-3">
            <a href="index.php" class="navbar-brand mx-sm-2">Calendrier</a>
        </nav>

        <?php 
            require './classes/Date/Month.php';

            try {
                $month = new App\Date\Month($_GET['month'] ?? null, $_GET['year'] ?? null); //?? = Si la valeur n'est pas défine alors ->
            } catch(\Exception $e) {
                $month = new App\Date\Month();
            }
            $firstDay = $month->getStartingDay();
            $firstDay = $firstDay->format('N') === '1' ? $firstDay : $month->getStartingDay()->modify('last monday');
        ?>

        <div class="d-flex flex-row align-items-center justify-content-between mx-sm-4">
            <h1><?= $month->toString(); ?></h1>
            <dv>
                <a href="/index.php?month=<?= $month->previousMonth()->month ?>&year=<?= $month->previousMonth()->year; ?>" class="btn btn-primary">&lt;</a>
                <a href="/index.php?month=<?= $month->nextMonth()->month ?>&year=<?= $month->nextMonth()->year; ?>" class="btn btn-primary">&gt;</a>
            </dv>
        </div>

        <table class="calendar__table calendar__table--<?= $month->getWeeks(); ?>weeks">
            <?php for($i = 0; $i < $month->getWeeks(); $i++): ?>
                <tr>
                    <?php 
                        foreach($month->days as $k => $day): 
                            $date = (clone $firstDay)->modify("+" . ($k + $i * 7) . "days");
                        ?>
                            <td class="<?= $month->withinMonth($date) ? '' : 'calendar__otherMonth'; ?>">
                                <?php if($i === 0): ?>
                                    <div class="calendar__weekday"><?= $day ?></div>
                                <?php endif; ?>
                                <div class="calendar__day"><?= $date->format('d'); ?></div>
                            </td>
                        <?php endforeach; ?>
                </tr>
            <?php endfor; ?>
        </table>
    </body>
</html>