<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\MenuItem;

class MenuItemSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * Truncates and re-seeds all sidebar menu items with correct routes.
     */
    public function run(): void
    {
        // Wipe slate clean to avoid stale/test entries
        MenuItem::truncate();

        // 1. Dashboard (Parent)
        $dashboard = MenuItem::create([
            'label'      => 'Dashboard',
            'icon'       => 'layout-dashboard',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        MenuItem::create([
            'label'      => 'Dashboard v1',
            'icon'       => 'circle',
            'route'      => 'dashboard',
            'url'        => null,
            'parent_id'  => $dashboard->id,
            'sort_order' => 1,
            'is_active'  => true,
        ]);

        MenuItem::create([
            'label'      => 'Dashboard v2',
            'icon'       => 'circle',
            'route'      => 'dashboard.v2',
            'url'        => null,
            'parent_id'  => $dashboard->id,
            'sort_order' => 2,
            'is_active'  => true,
        ]);

        MenuItem::create([
            'label'      => 'Dashboard v3',
            'icon'       => 'circle',
            'route'      => 'dashboard.v3',
            'url'        => null,
            'parent_id'  => $dashboard->id,
            'sort_order' => 3,
            'is_active'  => true,
        ]);

        // 2. Theme Generate
        MenuItem::create([
            'label'      => 'Theme Generate',
            'icon'       => 'palette',
            'route'      => 'theme.generate',
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 2,
            'is_active'  => true,
        ]);

        // 3. Widgets
        MenuItem::create([
            'label'      => 'Widgets',
            'icon'       => 'toy-brick',
            'route'      => 'widgets',
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 3,
            'is_active'  => true,
        ]);

        // 4. Layout Options (Parent)
        $layout = MenuItem::create([
            'label'      => 'Layout Options',
            'icon'       => 'layout',
            'route'      => 'layout.options',
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 4,
            'is_active'  => true,
        ]);

        // 5. UI Elements (Parent)
        $ui = MenuItem::create([
            'label'      => 'UI Elements',
            'icon'       => 'component',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 5,
            'is_active'  => true,
        ]);

        $uiItems = [
            ['label' => 'General', 'icon' => 'circle', 'route' => 'ui.general'],
            ['label' => 'Icons', 'icon' => 'circle', 'route' => 'ui.icons'],
            ['label' => 'Buttons', 'icon' => 'circle', 'route' => 'ui.buttons'],
            ['label' => 'Sliders', 'icon' => 'circle', 'route' => 'ui.sliders'],
            ['label' => 'Modals & Alerts', 'icon' => 'circle', 'route' => 'ui.modals-alerts'],
            ['label' => 'Cards', 'icon' => 'circle', 'route' => 'ui.cards'],
            ['label' => 'Timeline', 'icon' => 'circle', 'route' => 'ui.timeline'],
        ];
        foreach ($uiItems as $k => $item) {
            MenuItem::create(array_merge($item, [
                'parent_id'  => $ui->id,
                'sort_order' => $k + 1,
                'is_active'  => true,
            ]));
        }

        // 6. Mailbox (Parent)
        $mailbox = MenuItem::create([
            'label'      => 'Mailbox',
            'icon'       => 'mail',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 6,
            'is_active'  => true,
        ]);

        $mailboxItems = [
            ['label' => 'Inbox', 'icon' => 'circle', 'route' => 'mailbox.inbox'],
            ['label' => 'Compose', 'icon' => 'circle', 'route' => 'mailbox.compose'],
            ['label' => 'Read', 'icon' => 'circle', 'route' => 'mailbox.read'],
        ];
        foreach ($mailboxItems as $k => $item) {
            MenuItem::create(array_merge($item, [
                'parent_id'  => $mailbox->id,
                'sort_order' => $k + 1,
                'is_active'  => true,
            ]));
        }

        // 7. Forms (Parent)
        $forms = MenuItem::create([
            'label'      => 'Forms',
            'icon'       => 'file-text',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 7,
            'is_active'  => true,
        ]);

        $formItems = [
            ['label' => 'General Elements', 'icon' => 'circle', 'route' => 'forms.general'],
            ['label' => 'Advanced Elements', 'icon' => 'circle', 'route' => 'forms.advanced'],
            ['label' => 'Validation', 'icon' => 'circle', 'route' => 'forms.validation'],
        ];
        foreach ($formItems as $k => $item) {
            MenuItem::create(array_merge($item, [
                'parent_id'  => $forms->id,
                'sort_order' => $k + 1,
                'is_active'  => true,
            ]));
        }

        // 8. Tables (Parent)
        $tables = MenuItem::create([
            'label'      => 'Tables',
            'icon'       => 'table',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 8,
            'is_active'  => true,
        ]);

        $tableItems = [
            ['label' => 'Simple Tables', 'icon' => 'circle', 'route' => 'tables.simple'],
            ['label' => 'DataTables', 'icon' => 'circle', 'route' => 'tables.datatables'],
        ];
        foreach ($tableItems as $k => $item) {
            MenuItem::create(array_merge($item, [
                'parent_id'  => $tables->id,
                'sort_order' => $k + 1,
                'is_active'  => true,
            ]));
        }

        // --- PAGES SECTION ---
        MenuItem::create([
            'label'      => 'PAGES',
            'icon'       => 'section-header',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 9,
            'is_active'  => true,
        ]);

        $pages = MenuItem::create([
            'label'      => 'Pages',
            'icon'       => 'files',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 10,
            'is_active'  => true,
        ]);

        $pagesItems = [
            ['label' => 'Profile', 'icon' => 'circle', 'route' => 'profile.edit'],
            ['label' => 'Invoice', 'icon' => 'circle', 'route' => 'pages.invoice'],
            ['label' => 'Pricing', 'icon' => 'circle', 'route' => 'pages.pricing'],
            ['label' => 'FAQ', 'icon' => 'circle', 'route' => 'pages.faq'],
            ['label' => '404 Error', 'icon' => 'circle', 'route' => 'pages.error'],
        ];
        foreach ($pagesItems as $k => $item) {
            MenuItem::create(array_merge($item, [
                'parent_id'  => $pages->id,
                'sort_order' => $k + 1,
                'is_active'  => true,
            ]));
        }

        // --- EXAMPLES SECTION ---
        MenuItem::create([
            'label'      => 'EXAMPLES',
            'icon'       => 'section-header',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 11,
            'is_active'  => true,
        ]);

        $auth = MenuItem::create([
            'label'      => 'Auth',
            'icon'       => 'shield-lock',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 12,
            'is_active'  => true,
        ]);

        $authItems = [
            ['label' => 'Login', 'icon' => 'circle', 'route' => 'auth.login.mock'],
            ['label' => 'Register', 'icon' => 'circle', 'route' => 'auth.register.mock'],
            ['label' => 'Forgot Password', 'icon' => 'circle', 'route' => 'auth.forgot-password.mock'],
        ];
        foreach ($authItems as $k => $item) {
            MenuItem::create(array_merge($item, [
                'parent_id'  => $auth->id,
                'sort_order' => $k + 1,
                'is_active'  => true,
            ]));
        }

        // Custom Tools / Demos placed under dynamic headers
        MenuItem::create([
            'label'      => 'UTILITIES',
            'icon'       => 'section-header',
            'route'      => null,
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 13,
            'is_active'  => true,
        ]);

        MenuItem::create([
            'label'      => 'Users',
            'icon'       => 'users',
            'route'      => 'demo.users',
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 14,
            'is_active'  => true,
        ]);

        MenuItem::create([
            'label'      => 'Wizard Demo',
            'icon'       => 'wand-sparkles',
            'route'      => 'wizard.demo',
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 15,
            'is_active'  => true,
        ]);

        MenuItem::create([
            'label'      => 'Menu Architect',
            'icon'       => 'folder-tree',
            'route'      => 'admin.menus.index',
            'url'        => null,
            'parent_id'  => null,
            'sort_order' => 16,
            'is_active'  => true,
        ]);
    }
}
