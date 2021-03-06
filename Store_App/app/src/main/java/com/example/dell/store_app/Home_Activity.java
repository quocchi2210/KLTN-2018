package com.example.dell.store_app;

import android.content.Intent;
import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.Menu;
import android.view.MenuItem;

public class Home_Activity extends AppCompatActivity {

    private ViewPager viewpager_home;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

        initUI();
    }

    @Override
    public boolean onCreateOptionsMenu(Menu menu) {
        getMenuInflater().inflate(R.menu.menu_store, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item) {
        Intent intent;
        switch (item.getItemId()) {
            case R.id.menu_item_add_order:

                intent = new Intent(getBaseContext(), Add_Activity.class);
                startActivity(intent);

                break;
            case R.id.menu_item_manage_order:

                intent = new Intent(getBaseContext(), Store_Manage_Activity.class);
                startActivity(intent);
                break;

            case R.id.menu_item_home:

                intent = new Intent(getBaseContext(), Home_Activity.class);
                startActivity(intent);
                break;

        }
        return super.onOptionsItemSelected(item);
    }


    private void initUI(){
        viewpager_home = (ViewPager) findViewById(R.id.viewpager_home);
        Log.w("abc",viewpager_home.toString());
        viewpager_home.setAdapter(new Home_Adapter(getSupportFragmentManager()));

        TabLayout tabLayout = (TabLayout) findViewById(R.id.tablayout_home);
        tabLayout.setupWithViewPager(viewpager_home);

        tabLayout.getTabAt(0).setIcon(R.drawable.ic_home_black_24dp);
        tabLayout.getTabAt(1).setIcon(R.drawable.ic_format_align_left_black_24dp);
        tabLayout.getTabAt(2).setIcon(R.drawable.ic_account_box_24);

    }

    private class Home_Adapter extends FragmentStatePagerAdapter {

        private String listTab[] = {"Trang chủ","Hóa đơn","Thông tin"};
//        private Confirm_Fragment mConfirmFrament;
//        private Pending_Fragment mPendingFragment;
//        private Pickup_Fragment mPickupFragment;
//        private Delivery_Fragment mDeliveryFragment;
//        private Done_Fragment mDoneFragment;
//        private Cancel_Fragment mCancelFragment;

        public Home_Adapter(FragmentManager fm){
            super(fm);
        }


        @Override
        public Fragment getItem(int position) {
            if(position == 0){
                return new Fragment_Home();
            }else if(position == 1){
                return new Fragment_Order();
            }else if(position == 2){
                return new Fragment_Profile_Info();
            }

            return null;
        }

        @Override
        public int getCount() {
            return listTab.length;
        }

        @Nullable
        @Override
        public CharSequence getPageTitle(int position) {
            return listTab[position];
        }
    }
}

