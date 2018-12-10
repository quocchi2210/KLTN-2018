package com.example.dell.store_app;

import android.app.Dialog;
import android.content.Context;
import android.support.v7.app.AppCompatActivity;
import android.os.Bundle;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.LinearLayout;
import android.widget.ListView;
import android.widget.TextView;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.List;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class Store_Manage_Activity extends AppCompatActivity {

    private ArrayList<Store_Manage> data = new ArrayList<Store_Manage>();

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_store_manage);

        OkHttpClient client = new OkHttpClient();

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_input", "your_value")
                .build();

        Request request = new Request.Builder()
                //.url("http://192.168.1.16:8000/api/shipper/showOrder")
                .url(" http://192.168.0.132:8000/api/store/showOrder")
                .post(requestBody)
                //.addHeader("name_your_token", "your_token")
                .build();

        client.newCall(request).enqueue(new Callback() {
            @Override
            public void onFailure(Call call, IOException e) {
                e.printStackTrace();
            }

            @Override
            public void onResponse(Call call, Response response) throws IOException {
                final String yourResponse = response.body().string();

                if(response.isSuccessful()){
                    Log.w("Add_Activity","Add success");
                    //Toast.makeText(Add_Activity.this, "Add success", Toast.LENGTH_SHORT).show();

                    Store_Manage_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            JSONObject Jobject = null;
                            try {
                                ListView lv_store_mange = findViewById(R.id.list_view_store_manage);
                                Jobject = new JSONObject(yourResponse);

                                JSONArray Jarray = Jobject.getJSONArray("data");

                                for (int i = 0; i < Jarray.length(); i++) {
                                    JSONObject object = Jarray.getJSONObject(i);
                                    Log.w("myApp", object.toString());
                                    String billOfLading = object.getString("billOfLading");
                                    String address = object.getString("addressReceiver");
                                    data.add(new Store_Manage(billOfLading,address));
                                }

                                lv_store_mange.setAdapter(new Store_Manage_Adapter(Store_Manage_Activity.this, R.layout.list_store_manage_item, data));


                            } catch (JSONException e) {
                                e.printStackTrace();
                            }

                        }
                    });


                }else{
                    Log.w("Add_Activity","Add faild "+yourResponse.toString());
                }

            }
        });



    }


    private class Store_Manage_Adapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<Store_Manage> arrayStoreManage;

        public Store_Manage_Adapter(Context context, int layout, List<Store_Manage> store_manage_List){
            myContext = context;
            myLayout = layout;
            arrayStoreManage = store_manage_List;
        }

        @Override
        public int getCount() {
            return arrayStoreManage.size();
        }

        @Override
        public Object getItem(int position) {
            return null;
        }

        @Override
        public long getItemId(int position) {
            return 0;
        }

        @Override
        public View getView(int position, View convertView, ViewGroup parent) {

            LayoutInflater inflater = (LayoutInflater) myContext.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(myLayout, null);

            TextView bill_of_lading = (TextView) convertView.findViewById(R.id.bill_of_lading);
            TextView address = (TextView) convertView.findViewById(R.id.address);

            bill_of_lading.setText(arrayStoreManage.get(position).getBill_of_lading());
            address.setText(arrayStoreManage.get(position).getAddress());

            LinearLayout lnlo_store_manage = (LinearLayout) convertView.findViewById (R.id.lnlo_store_manage);

            final int vitri = position;

            lnlo_store_manage.setOnClickListener(new View.OnClickListener() {
                @Override
                public void onClick(View v) {

                }
            });

            return convertView;
        }
    }


    private class Store_Manage{

        private String bill_of_lading;
        private String address;

        public String getBill_of_lading() {
            return bill_of_lading;
        }

        public void setBill_of_lading(String bill_of_lading) {
            this.bill_of_lading = bill_of_lading;
        }

        public String getAddress() {
            return address;
        }

        public void setAddress(String address) {
            this.address = address;
        }

        Store_Manage(String bill_of_lading, String address){
            this.bill_of_lading = bill_of_lading;
            this.address = address;
        }


    }
}
