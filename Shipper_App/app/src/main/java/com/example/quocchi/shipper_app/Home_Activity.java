package com.example.quocchi.shipper_app;

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
import android.view.View;
import android.widget.Toast;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Home_Activity extends AppCompatActivity {

    private ViewPager viewpager_home;

    private String hostname = "luxexpress.cf";
    private String token = Login_Token.token;

    private CertificatePinner certificatePinner = new CertificatePinner.Builder()
            .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
            .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
            .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
            .build();

    private OkHttpClient client = new OkHttpClient.Builder()
            .certificatePinner(certificatePinner)
            .build();

    private Shipper_Position_Send obj;

    @Override
    public boolean onCreateOptionsMenu(Menu menu){
        getMenuInflater().inflate(R.menu.menu_shipper, menu);
        return super.onCreateOptionsMenu(menu);
    }

    @Override
    public boolean onOptionsItemSelected(MenuItem item){

        Intent intent;
        switch(item.getItemId()){
            case R.id.menu_item_history:
                //Toast.makeText(Order_Activity.this, "Ok: History",Toast.LENGTH_SHORT).show();
                intent = new Intent(getBaseContext(), History_Activity.class);
                startActivity(intent);
                break;
//            case R.id.menu_item_order:
//                intent = new Intent(getBaseContext(), Order_Activity.class);
//                startActivity(intent);
//                break;
//            case R.id.menu_item_order_received:
//                intent = new Intent(getBaseContext(), Order_Received_Activity.class);
//                startActivity(intent);
//                break;
//            case R.id.menu_item_search:
//                intent = new Intent(getBaseContext(), MapsActivity.class);
//                startActivity(intent);
//            case R.id.menu_item_fragment:
//                intent = new Intent(getBaseContext(), Fragment_Activity.class);
//                startActivity(intent);
//                break;

        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_home);

        initUI();

//        obj = Shipper_Position_Send.getInstance();
//        obj.setMyContext(Home_Activity.this);

        get_idorder_shipper_pickup();
    }

    private void initUI(){
        viewpager_home = (ViewPager) findViewById(R.id.viewpager_home);
        Log.w("abc",viewpager_home.toString());
        viewpager_home.setAdapter(new Home_Adapter(getSupportFragmentManager()));

        TabLayout tabLayout = (TabLayout) findViewById(R.id.tablayout_home);
        tabLayout.setupWithViewPager(viewpager_home);

        tabLayout.getTabAt(0).setIcon(R.drawable.ic_control_point);
        tabLayout.getTabAt(1).setIcon(R.drawable.ic_control_point);
        tabLayout.getTabAt(2).setIcon(R.drawable.ic_control_point);

    }

    private void get_idorder_shipper_pickup(){
        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_name_input", "your_value")
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/shipper/checkOrderShipper")
                .post(requestBody)
                .addHeader("Authorization", "Bearer " + token)
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                e.printStackTrace();
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String yourResponse = response.body().string();

                if (response.isSuccessful()) {

                        Home_Activity.this.runOnUiThread(new Runnable() {
                            @Override
                            public void run() {
                                JSONObject Jobject = null;

                                Log.w("get_idorder_shipper_pickup", yourResponse.toString());
                                try {

                                    Jobject = new JSONObject(yourResponse);
                                    String Jarray_data = Jobject.getString("data");

                                    if (Integer.parseInt(Jarray_data) > 0) {
                                        JSONArray Jarray = Jobject.getJSONArray("data_order");
                                        JSONObject object = Jarray.getJSONObject(0);
                                        Login_Token.id_order = object.getString("idOrder");

                                        Log.w("get_idorder_shipper_pickup", Login_Token.id_order);
                                    }

                                } catch (JSONException e) {
                                    Log.w("error deliveryfragment", yourResponse.toString());
                                    e.printStackTrace();
                                }

                            }
                        });

                } else {
                    Log.w("myApp", "ERROR Order received: " + yourResponse.toString());
                }


            };
        });
    }

    private class Home_Adapter extends FragmentStatePagerAdapter {

        private String listTab[] = {"Trang chủ","Hóa đơn","Thông tin"};
        private Confirm_Fragment mConfirmFrament;
        private Pending_Fragment mPendingFragment;
        private Pickup_Fragment mPickupFragment;
        private Delivery_Fragment mDeliveryFragment;
        private Done_Fragment mDoneFragment;
        private Cancel_Fragment mCancelFragment;

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
