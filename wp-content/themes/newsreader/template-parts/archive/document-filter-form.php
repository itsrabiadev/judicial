<form method="get" action="<?php echo esc_url( home_url( '/' ) ); ?>">
    <h4 class="p-b-10"><?php esc_html_e( 'Search The Document Archives', 'newsreader' ); ?></h4>

    <div class="field">
        <div class="columns is-marginless is-paddingless">
            <div class="column is-full-mobile is-three-quarters is-marginless is-paddingless">
                <div class="columns is-marginless is-paddingless is-mobile">
                    <p class="control has-icons-right is-three-fifths">
                        <input class="input m-r-20"
                               type="text"
                               placeholder="<?php esc_attr_e( 'Search documents', 'newsreader' ); ?>"
                               name="s"
                               value="<?php echo esc_attr( get_search_query() ); ?>">
                        <span class="icon is-small is-right">
                            <span class="fas fa-search has-text-primary"></span>
                        </span>
                    </p>
                    <div class="column is-two-fifths is-marginless is-paddingless">
                        <button type="submit"
                                class="button is-primary mobile-p-l-35 mobile-p-r-35">
                            <?php esc_html_e( 'Search', 'newsreader' ); ?>
                        </button>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <hr class="m-t-40 m-b-40"/>

    <!-- 📅 Date Filters -->
    <h4 class="p-b-5"><?php esc_html_e( 'Filter by Date', 'newsreader' ); ?></h4>
    <label class="is-bold"><?php esc_html_e( 'Select to filter by month and year', 'newsreader' ); ?></label>

    <div class="columns is-multiline m-t-5">
        <div class="column p-t-0">
            <div class="select is-block">
                <select class="input input-select" name="monthnum">
                    <option value=""><?php esc_html_e( 'Month', 'newsreader' ); ?></option>
                    <?php
                    for ( $m = 1; $m <= 12; $m++ ) {
                        printf(
                            '<option value="%1$d"%2$s>%3$s</option>',
                            $m,
                            selected( get_query_var( 'monthnum' ), $m, false ),
                            date_i18n( 'F', mktime( 0, 0, 0, $m, 1 ) )
                        );
                    }
                    ?>
                </select>
            </div>
        </div>

        <div class="column p-t-0">
            <div class="select is-block">
                <select class="input input-select" name="year">
                    <option value=""><?php esc_html_e( 'Year', 'newsreader' ); ?></option>
                    <?php
                    $current_year = date( 'Y' );
                    for ( $y = $current_year; $y >= 1995; $y-- ) {
                        printf(
                            '<option value="%1$d"%2$s>%1$d</option>',
                            $y,
                            selected( get_query_var( 'year' ), $y, false )
                        );
                    }
                    ?>
                </select>
            </div>
        </div>
        <input type="hidden" name="post_type" value="documents">

        <div class="column is-one-quarter p-t-0">
            <button type="submit" class="button is-primary">
                <?php esc_html_e( 'Search', 'newsreader' ); ?>
            </button>
        </div>
    </div>

    <hr class="m-t-40 m-b-40"/>
</form>
