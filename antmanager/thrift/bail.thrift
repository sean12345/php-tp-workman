namespace php Services.BailService
namespace java Services.BailService

exception InvalidException {
		1: i32 code
    2: string message
}

struct Bail {
	1: i64 dealerId,
	2: double bailAmount,
	3: double freezeAmount
}

service BailService{
		// 获取车商保证金
    Bail getDealerBail(1:i64 dealerId) throws (1:InvalidException ex),

    // 冻结车商保证金
    Bail freezeBail(1:i64 dealerId, 2:double amount, 3:i64 orderId) throws (1:InvalidException ex),

    // 解冻车商保证金
    Bail unfreezeBail(1:i64 dealerId, 2:double amount, 3:i64 orderId) throws (1:InvalidException ex),

    // 扣除车商保证金
    Bail decBail(1:i64 dealerId, 2:double amount) throws (1:InvalidException ex),

    // 充值车商保证金
    Bail incBail(1:i64 dealerId, 2:double amount) throws (1:InvalidException ex)


}
