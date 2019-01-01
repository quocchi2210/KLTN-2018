package com.example.quocchi.shipper_app;

import android.os.Bundle;
import android.support.annotation.Nullable;
import android.support.design.widget.TabLayout;
import android.support.v4.app.Fragment;
import android.support.v4.app.FragmentManager;
import android.support.v4.app.FragmentStatePagerAdapter;
import android.support.v4.view.ViewPager;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;

public class Fragment_Order extends Fragment {
    private View mRootView;
    private ViewPager mVpDemo;

    @Nullable
    @Override
    public View onCreateView(LayoutInflater inflater, @Nullable ViewGroup container, @Nullable Bundle savedInstanceState) {
        mRootView = inflater.inflate(R.layout.activity_fragment, container, false);
        initUI();

        return mRootView;
    }

    private void initUI(){
        mVpDemo = (ViewPager) mRootView.findViewById(R.id.vp_demo);
        mVpDemo.setAdapter(new Fragment_Adapter(getChildFragmentManager()));

        TabLayout tabLayout = (TabLayout) mRootView.findViewById(R.id.tablayout);
        tabLayout.setupWithViewPager(mVpDemo);

        tabLayout.getTabAt(0).setIcon(R.drawable.ic_control_point);
        tabLayout.getTabAt(1).setIcon(R.drawable.ic_control_point);
        tabLayout.getTabAt(2).setIcon(R.drawable.ic_control_point);

    }

    private class Fragment_Adapter extends FragmentStatePagerAdapter {

        private String listTab[] = {"Confirm","Pickup","Delivery"};
        private Confirm_Fragment mConfirmFrament;
        private Pending_Fragment mPendingFragment;
        private Pickup_Fragment mPickupFragment;
        private Delivery_Fragment mDeliveryFragment;
        private Done_Fragment mDoneFragment;
        private Cancel_Fragment mCancelFragment;

        public Fragment_Adapter(FragmentManager fm){
            super(fm);
            //mConfirmFrament = new Confirm_Fragment();
//           // mDeliveryFragment = new Delivery_Fragment();
            //mDoneFragment = new Done_Fragment();
        }


        @Override
        public Fragment getItem(int position) {
            if(position == 0){
                return new Confirm_Fragment();
            }else if(position == 1){
                return new Pickup_Fragment();
            }else if(position == 2){
                return new Delivery_Fragment();
            }
//            else if(position == 3){
//                return mDoneFragment;
//            }else if(position == 4) {
//                return mCancelFragment;
//            }
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
