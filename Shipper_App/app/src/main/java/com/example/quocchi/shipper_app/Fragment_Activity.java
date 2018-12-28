package com.example.quocchi.shipper_app;

import android.support.annotation.Nullable;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;
import android.support.v4.view.ViewPager;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;

public class Fragment_Activity extends AppCompatActivity {

    private ViewPager mVpDemo;

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_fragment);

        initUI();


    }

    private void initUI(){
        mVpDemo = (ViewPager) findViewById(R.id.vp_demo);
        mVpDemo.setAdapter(new Fragment_Adapter(getSupportFragmentManager()));

        TabLayout tabLayout = (TabLayout) findViewById(R.id.tablayout);
        tabLayout.setupWithViewPager(mVpDemo);

        tabLayout.getTabAt(0).setIcon(R.drawable.ic_control_point);
        tabLayout.getTabAt(1).setIcon(R.drawable.ic_control_point);
        tabLayout.getTabAt(2).setIcon(R.drawable.ic_control_point);
        tabLayout.getTabAt(3).setIcon(R.drawable.ic_control_point);
        tabLayout.getTabAt(4).setIcon(R.drawable.ic_control_point);
    }

    private class Fragment_Adapter extends FragmentStatePagerAdapter {

        private String listTab[] = {"Pending","Confirm","Pickup","Done","Cancel"};
        private Confirm_Fragment mConfirmFrament;
        private Pending_Fragment mPendingFragment;
        private Pickup_Fragment mPickupFragment;
        private Done_Fragment mDoneFragment;
        private Cancel_Fragment mCancelFragment;

        public Fragment_Adapter(FragmentManager fm){
            super(fm);
            mConfirmFrament = new Confirm_Fragment();
            mPendingFragment = new Pending_Fragment();
            mPickupFragment = new Pickup_Fragment();
            mDoneFragment = new Done_Fragment();
            mCancelFragment = new Cancel_Fragment();
        }


        @Override
        public Fragment getItem(int position) {
            if(position == 0){
                return mPendingFragment;
            }else if(position == 1){
                return mConfirmFrament;
            }else if(position == 2){
                return mPickupFragment;
            }else if(position == 3){
                return mDoneFragment;
            }else if(position == 4) {
                return mCancelFragment;
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
