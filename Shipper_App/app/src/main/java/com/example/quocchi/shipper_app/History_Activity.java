package com.example.quocchi.shipper_app;

import android.content.Context;
import android.content.Intent;
import android.os.Bundle;
import android.support.v7.app.AppCompatActivity;
import android.util.Log;
import android.view.LayoutInflater;
import android.view.Menu;
import android.view.MenuItem;
import android.view.View;
import android.view.ViewGroup;
import android.widget.BaseAdapter;
import android.widget.BaseExpandableListAdapter;
import android.widget.ExpandableListView;
import android.widget.TextView;

import com.android.volley.AuthFailureError;
import com.android.volley.RequestQueue;
import com.android.volley.VolleyError;
import com.android.volley.toolbox.StringRequest;
import com.android.volley.toolbox.Volley;

import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;

import java.io.IOException;
import java.util.ArrayList;
import java.util.HashMap;
import java.util.List;
import java.util.Map;

import okhttp3.Call;
import okhttp3.Callback;
import okhttp3.CertificatePinner;
import okhttp3.MultipartBody;
import okhttp3.OkHttpClient;
import okhttp3.Request;
import okhttp3.RequestBody;
import okhttp3.Response;

public class History_Activity extends AppCompatActivity {

    private ArrayList<History> data = new ArrayList<History>();

    ExpandableListView expandableListView;
    List<NameStore> listContact = new ArrayList<NameStore>();
    List<String> listdataHeader = new ArrayList<String>();
    List<String> list = new ArrayList<String>();
    HashMap<String,ArrayList<History>> listdataChild = new HashMap<String,ArrayList<History>>();

    CustomExpandableListView customExpandableListView;

    private String token = Login_Token.token;
    private String hostname = "luxexpress.cf";

    CertificatePinner certificatePinner = new CertificatePinner.Builder()
            .add(hostname, "sha256/MPTkwqvsxxFu44jSBUkloPwzP8VQwYEaGybVkEmRuww=")
            .add(hostname, "sha256/YLh1dUR9y6Kja30RrAn7JKnbQG/uEtLMkBgFF2Fuihg=")
            .add(hostname, "sha256/Vjs8r4z+80wjNcr1YKepWQboSIRi63WsWXhIMN+eWys=")
            .build();

    OkHttpClient client = new OkHttpClient.Builder()
            .certificatePinner(certificatePinner)
            .build();

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
            case R.id.menu_item_order:
                intent = new Intent(getBaseContext(), Order_Activity.class);
                startActivity(intent);
                break;
            case R.id.menu_item_order_received:
                intent = new Intent(getBaseContext(), Order_Received_Activity.class);
                startActivity(intent);
                break;
            case R.id.menu_item_search:
                intent = new Intent(getBaseContext(), MapsActivity.class);
                startActivity(intent);
                break;

        }

        return super.onOptionsItemSelected(item);
    }

    @Override
    protected void onCreate(Bundle savedInstanceState) {
        super.onCreate(savedInstanceState);
        setContentView(R.layout.activity_history);

//        expandableListView = (ExpandableListView) findViewById(R.id.expandableListView);
//        listdataHeader = new ArrayList<>();
//        listdataChild = new HashMap<String,ArrayList<History>>();
//        listdataHeader.add("A store");
//        listdataHeader.add("B store");
//        listdataHeader.add("C store");
//        ArrayList<History> store_a = new ArrayList<History>();
//        store_a.add(new History("math",1));
//        store_a.add(new History("math1",1));
//        store_a.add(new History("math2",1));
//        ArrayList<History> store_b = new ArrayList<History>();
//        store_b.add(new History("english",1));
//        store_b.add(new History("english1",1));
//        store_b.add(new History("english2",1));
//        ArrayList<History> store_c = new ArrayList<History>();
//        store_c.add(new History("gaphic",1));
//        store_c.add(new History("gaphic1",1));
//        store_c.add(new History("gaphic2",1));
//        listdataChild.put(listdataHeader.get(0),store_a);
//        listdataChild.put(listdataHeader.get(1),store_b);
//        listdataChild.put(listdataHeader.get(2),store_c);
//        customExpandableListView = new CustomExpandableListView(History_Activity.this,listdataHeader,listdataChild);
//        expandableListView.setAdapter(customExpandableListView);

        //OkHttpClient client = new OkHttpClient();

        RequestBody requestBody = new MultipartBody.Builder()
                .setType(MultipartBody.FORM)
                .addFormDataPart("your_name_input", "your_value")
                .build();

        Request request = new Request.Builder()
                .url("https://luxexpress.cf/api/shipper/showHistory")
                //.url("http://192.168.0.132:8000/api/shipper/showHistory")
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

                    History_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            JSONObject Jobject = null;
                            try {
                                Jobject = new JSONObject(yourResponse);
                                Log.w("history", yourResponse.toString());

                                expandableListView = (ExpandableListView) findViewById(R.id.expandableListView);
                                listdataHeader = new ArrayList<>();
                                listdataChild = new HashMap<String,ArrayList<History>>();

                                List<ArrayList<History>> Listhistory = new ArrayList<ArrayList<History>>();

                                JSONArray store_name_array = Jobject.getJSONArray("store_name");
                                JSONArray data = Jobject.getJSONArray("data");

                                Log.w("history", data.toString());

                                ArrayList<History> array_tmp_value = new ArrayList<History>();
                                ArrayList<History> array_tmp = new ArrayList<History>();

                                for (int i = 0; i < store_name_array.length(); i++) {
                                    JSONObject object = store_name_array.getJSONObject(i);
                                    listdataHeader.add(object.getString("nameStore"));

                                    for(int j = 0; j<data.length(); j++){
                                        JSONObject object_data = data.getJSONObject(j);
                                        if(object.getString("idStore") == object_data.getString("idStore")){

                                            Log.w("History ",object_data.toString());

                                            String billOfLading = object_data.getString("billOfLading");
                                            String address = object_data.getString("addressReceiver");
                                            String name_received = object_data.getString("nameReceiver");
                                            String phone_received = object_data.getString("phoneReceiver");
                                            String total_money = object_data.getString("totalMoney");

                                            if(billOfLading.equals("null")){
                                                billOfLading = "";
                                            }
                                            if(name_received.equals("null")){
                                                name_received = "";
                                            }
                                            if(phone_received.equals("null")){
                                                phone_received = "";
                                            }
                                            if(address.equals("null")){
                                                address = "";
                                            }
                                            if(total_money.equals("null")){
                                                total_money = "";
                                            }

                                            array_tmp.add(new History(billOfLading,address,name_received,phone_received,total_money));
                                        }


                                    }
                                    array_tmp_value = (ArrayList<History>)array_tmp.clone();
                                    Listhistory.add(array_tmp_value);
                                    array_tmp.clear();
                                }

                                for(int i = 0; i < store_name_array.length(); i++){

                                    listdataChild.put(listdataHeader.get(i), Listhistory.get(i));

                                }

                                Log.w("History detial",Listhistory.toString());

                                customExpandableListView = new CustomExpandableListView(History_Activity.this,listdataHeader,listdataChild);
                                expandableListView.setAdapter(customExpandableListView);



                            } catch (JSONException e) {
                                Log.w("history", "error"+yourResponse.toString());
                                e.printStackTrace();
                            }

                        }
                    });
                } else {
                    Log.w("history","error not success"+ yourResponse.toString());
                }


            }
        });

    }

    private void getNameStore(String url){
        RequestQueue requestQueue = Volley.newRequestQueue(this);


        StringRequest stringRequest = new StringRequest(com.android.volley.Request.Method.POST, url, new com.android.volley.Response.Listener<String>() {
            @Override
            public void onResponse(String response) {


                    final String response1 = response;
                    Log.w("List Header Out", listdataHeader.toString());
                    History_Activity.this.runOnUiThread(new Runnable() {
                        @Override
                        public void run() {
                            try{
                                JSONObject Jobject = new JSONObject(response1);
                                JSONArray Jarray = Jobject.getJSONArray("data");
                                for (int i = 0; i < Jarray.length(); i++) {
                                    JSONObject object = Jarray.getJSONObject(i);

                                    listdataHeader.add(object.getString("nameStore"));
                                }

                                list = listdataHeader;
                            } catch (JSONException e) {
                                e.printStackTrace();
                            }

                        }
                    });


                    //Toast.makeText(History_Activity.this,"OK CON TETE",Toast.LENGTH_SHORT).show();

            }
        }, new com.android.volley.Response.ErrorListener() {
            @Override
            public void onErrorResponse(VolleyError error) {

            }
        }){
            @Override
            protected Map<String, String> getParams() throws AuthFailureError {
                Map<String, String> params = new HashMap<>();
                params.put("your_input","your_value");
                return super.getParams();
            }
        };

        requestQueue.add(stringRequest);

    }

    public class CustomExpandableListView extends BaseExpandableListAdapter {

        Context context;
        List<String> listHeader;
        HashMap<String,ArrayList<History>> listChild;

        public CustomExpandableListView(Context context, List<String> listHeader, HashMap<String, ArrayList<History>> listChild) {
            this.context = context;
            this.listHeader = listHeader;
            this.listChild = listChild;
        }

        @Override
        public int getGroupCount() {
            return listHeader.size();
        }

        @Override
        public int getChildrenCount(int groupPosition) {
            return listChild.get(listHeader.get(groupPosition)).size();
        }

        @Override
        public Object getGroup(int groupPosition) {
            return listHeader.get(groupPosition);
        }

        @Override
        public Object getChild(int groupPosition, int childPosition) {
            return listChild.get(listHeader.get(groupPosition)).get(childPosition);
        }

        @Override
        public long getGroupId(int groupPosition) {
            return groupPosition;
        }

        @Override
        public long getChildId(int groupPosition, int childPosition) {
            return childPosition;
        }

        @Override
        public boolean hasStableIds() {
            return false;
        }

        @Override
        public View getGroupView(int groupPosition, boolean isExpanded, View convertView, ViewGroup parent) {
            String headerTitle = (String) getGroup(groupPosition);

            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(R.layout.group_history_view,null);
            TextView txtheader = (TextView) convertView.findViewById(R.id.txt_history_header);
            txtheader.setText(headerTitle);

            return convertView;
        }

        @Override
        public View getChildView(int groupPosition, int childPosition, boolean isLastChild, View convertView, ViewGroup parent) {
            History arrayHistory = (History) getChild(groupPosition,childPosition);

            //History a = listChild.get(listHeader.get(groupPosition));
            LayoutInflater inflater = (LayoutInflater) context.getSystemService(Context.LAYOUT_INFLATER_SERVICE);

            convertView = inflater.inflate(R.layout.group_history_child_view,null);

           // TextView txta = (TextView) convertView.findViewById(R.id.txt_a);
            //TextView txtb = (TextView) convertView.findViewById(R.id.txt_b);

            //txta.setText( test.getA().toString());
           // txtb.setText( test.getA().toString());

            TextView bill_of_lading = (TextView) convertView.findViewById(R.id.bill_of_lading);
            TextView address = (TextView) convertView.findViewById(R.id.address);
            TextView mobile_receive = (TextView) convertView.findViewById(R.id.mobile_receive);
            TextView name_receive = (TextView) convertView.findViewById(R.id.name_receive);
            TextView total_money = (TextView) convertView.findViewById(R.id.total_money);

            bill_of_lading.setText("Order " + arrayHistory.getBillOfLading());
            address.setText(arrayHistory.getAddress());
            mobile_receive.setText(arrayHistory.getName_received());
            name_receive.setText(arrayHistory.getPhone_received());
            total_money.setText(arrayHistory.getTotal_money() + " VNĐ");

            return convertView;
        }

        @Override
        public boolean isChildSelectable(int groupPosition, int childPosition) {
            return true;
        }
    }

    private class HistoryAdapter extends BaseAdapter {

        Context myContext;
        int myLayout;
        List<History> arrayOrder;

        public HistoryAdapter(Context context, int layout, List<History> orderList){
            myContext = context;
            myLayout = layout;
            arrayOrder = orderList;
        }

        @Override
        public int getCount() {
            return arrayOrder.size();
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

            //TextView list_item_text = (TextView) convertView.findViewById(R.id.list_item_text);

            final int vitri = position;

//            list_item_text.setText(data.get(position).getA());
//            Button list_item_btn = (Button) convertView.findViewById(R.id.list_item_btn);
//
//            list_item_btn.setOnClickListener(new View.OnClickListener() {
//                @Override
//                public void onClick(View view) {
//                    Toast.makeText(Order_Activity.this,data.get(vitri).getA(),Toast.LENGTH_SHORT).show();
//                }
//            });

            return convertView;
        }
    }

//    private class HistoryList{
//        private List<ArrayList<History>> Listhistory;
//
//
//        public HistoryList() {
//
//        }
//
//        public HistoryList(List<ArrayList<History>> listhistory) {
//            Listhistory = listhistory;
//        }
//
//        public HistoryList getListihistory() {
//            return HistoryList;
//        }
//
//        public void setListhistory(ArrayList<History> listhistory_e,) {
//            Listhistory.add(listhistory_e);
//        }
//
//        public int size(){
//            return Listhistory.size();
//        }
//    }


    private class History{

        private String billOfLading;
        private String address;
        private String name_received;
        private String phone_received;
        private String total_money;

        public History(String billOfLading, String address, String name_received, String phone_received, String total_money) {
            this.billOfLading = billOfLading;
            this.address = address;
            this.name_received = name_received;
            this.phone_received = phone_received;
            this.total_money = total_money;
        }

        public String getBillOfLading() {
            return billOfLading;
        }

        public void setBillOfLading(String billOfLading) {
            this.billOfLading = billOfLading;
        }

        public String getAddress() {
            return address;
        }

        public void setAddress(String address) {
            this.address = address;
        }

        public String getName_received() {
            return name_received;
        }

        public void setName_received(String name_received) {
            this.name_received = name_received;
        }

        public String getPhone_received() {
            return phone_received;
        }

        public void setPhone_received(String phone_received) {
            this.phone_received = phone_received;
        }

        public String getTotal_money() {
            return total_money;
        }

        public void setTotal_money(String total_money) {
            this.total_money = total_money;
        }
    }

    private class NameStore{
        private int id_store;
        private String name_store;
        public NameStore(int id_store, String name_store) {
            this.id_store = id_store;
            this.name_store = name_store;
        }

        public int getId_store() {
            return id_store;
        }

        public void setId_store(int id_store) {
            this.id_store = id_store;
        }

        public String getName_store() {
            return name_store;
        }

        public void setName_store(String name_store) {
            this.name_store = name_store;
        }

    }
}

